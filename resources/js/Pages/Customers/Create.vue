<template>
    <AppLayout title="Customer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Customer Information
                </template>

                <template #description>
                    Set the customer's information.
                </template>

                <template #form>
                    <InputForm text="Name" v-model="form.name"></InputForm>
                    <InputForm text="Phone" v-model="form.phone" type="number"></InputForm>
                    <InputForm text="Birth Date" v-model="form.birth_date" type="date"></InputForm>
                    <SelectForm v-model="form.gender" text="Gender">
                        <option value="F">Female</option>
                        <option value="M">Male</option>
                    </SelectForm>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.customers.index'))">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>

            <SectionBorder />

            <FormSection @submitted="submit">
                <template #title>
                    Plan Information
                </template>

                <template #description>
                    Set the plan's information.
                    <br>
                    <template v-if="customer">
                        <p v-if="!customer.plan" class="mt-2 text-red-600">
                            El usuario no tiene un plan creado, se procederá a crear uno nuevo con los datos ingresados.
                        </p>
                        <p v-if="customer.plan" class="mt-2 text-indigo-600">
                            El usuario tiene un plan existente, se actualizará con los datos introducidos y también se
                            actualizará el ingreso correspondiente.
                            <span class="block mt-2"></span>
                            Si en cambio desea crear un nuevo plan, haga click aqui.
                        </p>
                    </template>
                </template>

                <template #form>
                    <SelectForm v-model="form.service_id" text="Service" name="service_id">
                        <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="form.period" text="Period">
                        <option v-for="period in periods" :value="period.key">{{ period.label }}</option>
                    </SelectForm>
                    <InputForm text="Start Date" v-model="form.start_date" type="date"></InputForm>
                    <InputForm text="Discount" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Note" v-model="form.note"></InputForm>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.customers.index'))">
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
import SectionBorder from '@/Components/SectionBorder.vue';
import useNotify from "@/Use/notify.js";

const props = defineProps({
    customer: {
        type: Object, required: false
    },
    isNew: {
        type: Boolean, default: true
    },
    periods: {
        type: Array, required: true
    },
    services: {
        type: Object, required: true
    }
})

const notify = useNotify();

const form = useForm({
    id: props.customer?.id ?? null,
    name: props.customer?.name ?? '',
    phone: props.customer?.phone ?? '',
    birth_date: props.customer?.birth_date ?? '',
    gender: props.customer?.gender ?? 'F',

    period: props.customer?.plan?.period ?? props.periods[0].key,
    start_date: props.customer?.plan?.start_date ?? '',
    discount: props.customer?.plan?.discount ?? 0,
    note: props.customer?.plan?.note ?? '',
    service_id: props.customer?.plan?.service_id ?? props.services[0].id,
});

function submit() {
    if (props.isNew) {
        form.post(route('dashboard.customers.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Customer created successfully!');
                router.get(route('dashboard.customers.index'));
            },
        });
    } else {
        form.put(route('dashboard.customers.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Customer updated successfully!');
                router.get(route('dashboard.customers.index'));
            },
        });
    }
}

</script>
