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
                    Informacion del plan
                </template>

                <template #description>
                    <div class="mt-3">
                        Cliente: <span class="uppercase"> {{ props.customer.name }}</span>
                    </div>
                    <div>
                        Estado del plan: <span class="uppercase"> {{ isCurrentActive ? 'Activo' : 'Expirado' }}</span>
                    </div>
                </template>

                <template #form>
                    <div class="grid grid-cols-2 gap-4">
                        <SelectForm v-model="form.service_id" text="Servicio" required name="service_id">
                            <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                        </SelectForm>
                        <SelectForm v-model="form.period" text="Periodo" required>
                            <option value="" selected>Seleccionar periodo</option>
                            <option v-for="price in prices" :value="price.period">
                                {{ periodLabel[price.period] }} - C$ {{ price.value }}
                            </option>
                        </SelectForm>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <InputForm text="Inicio del plan" v-model="form.start_date" type="date" />
                        <InputForm text="Fin del plan" v-model="end_date" type="date" disabled />
                    </div>

                    <div v-if="!isCurrentActive && plan" class="mb-4">
                        <div class="mb-3 text-indigo-400">
                            El plan anterior finalizó el {{ Carbon.create(plan.end_date).format('d/m/Y') }}
                        </div>
                        <Checkbox v-model:checked="startFromLastPlan" text="Continuar el plan anterior"
                            class="col-span-4" />
                    </div>

                    <InputForm text="Descuento C$ (Beca)" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Nota" v-model="form.note"></InputForm>

                    <div class="block col-span-4 mb-4">
                        <Checkbox v-model:checked="form.save_note" text="Guardar en notas" />
                    </div>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.customers.index'))">
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
import Checkbox from '@/Components/Checkbox.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import FormSection from '@/Components/FormSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { periodLabel } from '@/Use/periodLabel.js';
import { toast } from '@/Use/toast.js';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    services: {
        type: Object, required: false
    },
    plan: {
        type: Object, required: false
    },
    customer: {
        type: Object, required: true
    },
    isCurrentActive: {
        type: Boolean, required: true
    },
})

const startFromLastPlan = ref(false)

const form = useForm({
    plan_id: props.plan?.id,
    price: props.plan?.price ?? 0,
    period: props.plan?.period,
    start_date: props.isCurrentActive ? Carbon.create(props.plan.end_date).addDays(1).format() : Carbon.today(),
    end_date: props.plan?.end_date,
    discount: props.plan?.discount ?? 0,
    note: props.plan?.note ?? "",
    service_id: props.plan?.service_id ?? props.services[0].id,
    save_note: false,
});

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
    { name: 'Pagar', route: 'dashboard.customers.plans.create', params: [props.customer.id] },
]

//Obtener los precios del servicio seleccionado
const prices = computed(() => {
    return props.services.find(service => service.id == form.service_id)?.prices ?? [];
});

//Calcular el total del plan
const total = computed(() => {
    if (!form.period) return 0;
    return prices.value.find(price => price.period == form.period)?.value - form.discount;
});

watch(() => form.service_id, () => {
    if (!prices.value.find(price => price.period == form.period)) {
        form.period = prices.value[prices.value.length - 1].period;
    }
}, { immediate: true });

watch(() => startFromLastPlan.value, (value) => {
    if (value) {
        form.start_date = Carbon.create(props.plan.end_date).addDays(1).format();
    } else {
        form.start_date = Carbon.today();
    }
});

const end_date = computed(() => {
    return Carbon.create(form.start_date).addPeriod(parseInt(form.period)).addDays(-1).format();
});

function submit() {
    form.price = total.value;
    form.end_date = end_date.value;

    form.post(route('dashboard.customers.plans.store', props.customer.id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Guardado');
        },
    });
}

</script>