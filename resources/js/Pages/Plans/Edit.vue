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
                    <br>
                    <template v-if="plan.customer">
                        <!-- <p v-if="!plan.customer.plan" class="mt-2 text-red-600">
                            El usuario no tiene un plan creado, se procederá a crear uno nuevo con los datos ingresados.
                        </p>
                        <p v-if="customer.plan" class="mt-2 text-indigo-600">
                            El usuario tiene un plan existente, se actualizará con los datos introducidos y también se
                            actualizará el ingreso correspondiente.
                            <span class="block mt-2"></span>
                            Si en cambio desea crear un nuevo plan, haga click aqui.
                        </p> -->
                    </template>
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
                    <InputForm text="Start Date" v-model="form.start_date" type="date"></InputForm>
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

const props = defineProps({
    services: {
        type: Object, required: false
    },
    plan: {
        type: Boolean, default: true
    },
})

const notify = useNotify();
const prices = ref([])

const total = computed(() => {
    if (form.period && prices.value.length > 0) {
        const price = prices.value.find(price => price.period == form.period);
        return price.value - form.discount;
    }
    return 0;
});

const form = useForm({
    id: props.plan?.id ?? null,
    amount: props.plan?.amount ?? 0,
    period: props.plan?.period ?? null,
    start_date: props.plan?.start_date ?? null,
    discount: props.plan?.discount ?? 0,
    note: props.plan?.note ?? '',
    service_id: props.plan?.service_id ?? props.services[0].id,
});

watch(() => form.service_id, (value) => {
    prices.value = props.services.find(service => service.id == value).prices;
    form.period = prices.value.find(price => price.period == form.period) ? form.period : prices.value[0].period;
}, { immediate: true });

function submit() {
    form.amount = total.value;

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
