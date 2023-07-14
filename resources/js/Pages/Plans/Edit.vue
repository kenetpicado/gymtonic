<template>
    <AppLayout title="Customer" :breads="breads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plan
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Informacion del Plan
                </template>

                <template #description>
                    <template v-if="isCurrentActive">
                        <div>
                            El plan se encuentra activo, por lo que se asume un pago adelantado.
                        </div>
                        <div>
                            La fecha de fin del plan se actualizara en funcion de la fecha anterior:
                            {{ Carbon.create(plan.end_date).format('d/m/Y') }} y el periodo seleccionado: {{ form.period }}
                            dias.
                        </div>
                    </template>
                </template>

                <template #form>
                    <SelectForm v-model="form.service_id" text="Service" name="service_id">
                        <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="form.period" text="Period">
                        <option value="" disabled selected>Select a option</option>
                        <option v-for="price in prices" :value="price.period">
                            {{ periodLabel[price.period] }} - {{ price.value }} C$
                        </option>
                    </SelectForm>

                    <template v-if="!isCurrentActive">
                        <Checkbox v-model:checked="startFromLast" text="Continuar el plan anterior" class="col-span-4" />
                        <InputForm v-if="!startFromLast" text="Start Date" v-model="form.start_date" type="date"></InputForm>
                    </template>

                    <InputForm text="End Date" v-model="end_date" type="date" disabled></InputForm>
                    <InputForm text="Discount" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Note" v-model="form.note"></InputForm>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.plans.index'))">
                        Cancelar
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';
import { Plan } from '@/Classes/Plan.js';
import InputForm from '@/Components/Form/InputForm.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import FormSection from '@/Components/FormSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { calculateTotal, watchForPrices } from '@/Use/helpers.js';
import { toast } from '@/Use/toast.js';
import { router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { periodLabel } from '@/Use/periodLabel.js';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    services: {
        type: Object, required: false
    },
    plan: {
        type: Boolean, default: true
    },
    isCurrentActive: {
        type: Boolean, required: true
    }
})

const prices = ref([])
const startFromLast = ref(false)
const form = useForm(new Plan(props.plan, props.services[0].id, props.isCurrentActive));
let startFromDate = null;

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Planes', route: 'dashboard.plans.index' },
    { name: 'Actualizar', route: 'dashboard.plans.edit', params: [form.plan_id] },
]

const total = computed(() => {
    return calculateTotal({ period: form.period, discount: form.discount }, prices.value);
});

const end_date = computed(() => {

    if (props.isCurrentActive) {
        startFromDate = form.end_date
    } else {
        startFromDate = startFromLast.value ? form.end_date : form.start_date;
    }

    const date = new Carbon(startFromDate)
        .addPeriod(parseInt(form.period))
        .addDays(props.isCurrentActive || startFromLast.value ? 0 : -1);

    // if (props.isCurrentActive || startFromLast.value) {
    //     date.addDays();
    // }

    return date.format('Y-m-d');
});

watchForPrices(form, props.services, prices);

function submit() {
    form.price = total.value;
    form.end_date = end_date.value;

    form.put(route('dashboard.plans.update', form.plan_id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Plan created successfully!');
            router.get(route('dashboard.plans.index'));
        },
    });
}

</script>
