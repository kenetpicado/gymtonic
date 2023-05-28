<template>
    <AppLayout title="Customer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plans
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Plan Information
                </template>

                <template #description>
                    Set the plan's information.
                </template>

                <template #form>
                    <SelectForm v-model="form.service_id" text="Service" name="service_id">
                        <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="form.period" text="Period">
                        <option value="" disabled selected>Select a option</option>
                        <option v-for="price in prices" :value="price.period">
                            {{ price.period_label }} - {{ price.value }} C$
                        </option>
                    </SelectForm>
                    <template v-if="isCurrentActive">
                        <div class="col-span-4">
                            El plan se encuentra activo, por lo que se asume un pago adelantado.
                            La fecha de fin del plan se actualizara en funcion de la fecha anterior
                            ({{ plan.end_date_formated }}) y el periodo
                            seleccionado ({{ periodLabelSelected }})
                        </div>
                        <div class="col-span-4  font-medium text-gray-900">
                            End date: <span class="badge-blue text-sm">{{ newEndDateLabel }}</span>
                        </div>
                    </template>
                    <template v-else>
                        <InputForm text="Start Date" v-model="form.start_date" type="date"></InputForm>
                        <div class="col-span-4  font-medium text-gray-900">
                            Last Day: <span class="badge-danger text-sm">{{ newEndDateLabel }}</span>
                        </div>
                        <div class="col-span-4  font-medium text-gray-900">
                            Next Payment: <span class="badge-blue text-sm">{{ nextPayment }}</span>
                        </div>
                    </template>
                    <InputForm text="Discount" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Note" v-model="form.note"></InputForm>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        <h3 v-if="form.period && prices.length > 0">
                            Total: {{ total }} C$
                        </h3>
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.plans.index'))">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '../../Components/FormSection.vue';
import { router, useForm } from '@inertiajs/vue3';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import useNotify from "@/Use/notify.js";
import { defineProps, watch, ref, computed } from 'vue';
import { Datep } from '@/Classes/Datep.js';

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

const notify = useNotify();
const prices = ref([])
const today = new Datep().format('Y-m-d');

const total = computed(() => {
    if (form.period && prices.value.length > 0) {
        const price = prices.value.find(price => price.period == form.period);
        return price.value - form.discount;
    }
    return 0;
});

const periodLabelSelected = computed(() => {
    if (form.period && prices.value.length > 0) {
        const price = prices.value.find(price => price.period == form.period);
        if (price.period == 30) {
            return '1 mes';
        } else {
            return `${price.period} dia(s)`;
        }
    }
    return 'No hay periodo seleccionado';
});

const newEndDate = computed(() => {
    const date = new Datep(props.isCurrentActive ? form.end_date : form.start_date);
    date.addPeriod(parseInt(form.period));

    if (props.isCurrentActive) {
        date.addDays();
    }

    return date.format('Y-m-d');
});

const newEndDateLabel = computed(() => {
    const [year, month, day] = newEndDate.value.split('-');
    return `${day}/${month}/${year}`;
});

const nextPayment = computed(() => {
    const [year, month, day] = newEndDate.value.split('-');
    return `${Number(day) + 1}/${month}/${year}`;
});

const form = useForm({
    id: props.plan?.id ?? null,
    amount: props.plan?.amount ?? 0,
    period: props.plan?.period ?? null,
    start_date: props.isCurrentActive ? props.plan?.start_date : today,
    end_date: props.plan?.end_date ?? null,
    discount: props.plan?.discount ?? 0,
    note: props.plan?.note ?? '',
    service_id: props.plan?.service_id ?? props.services[0].id,
});

watch(() => form.service_id, (value) => {
    prices.value = props.services.find(service => service.id == value).prices;
    form.period = prices.value.find(price => price.period == form.period) ? form.period : prices.value[prices.value.length - 1].period;
}, { immediate: true });

function submit() {
    form.amount = total.value;
    form.end_date = newEndDate.value;

    form.put(route('dashboard.plans.update', form.id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            notify.success('Customer updated successfully!');
            router.get(route('dashboard.plans.index'));
        },
    });
}

</script>
