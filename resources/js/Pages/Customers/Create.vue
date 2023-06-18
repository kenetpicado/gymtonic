<template>
    <AppLayout title="Customer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Customers
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="saveCustomer">
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
                    <Link :href="route('dashboard.customers.index')">
                        <SecondaryButton>
                            Cancel
                        </SecondaryButton>
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </PrimaryButton>
                </template>
            </FormSection>

            <SectionBorder />

            <FormSection @submitted="saveCustomer">
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
                        <p v-if="customer.plan" class="mt-2">
                            El usuario tiene un plan existente, se actualizará con los datos introducidos y también se
                            actualizará el ingreso correspondiente.
                            <span class="block mt-2"></span>
                            Si en cambio desea crear un nuevo plan
                            <br>
                            <PrimaryButton class="mt-2"
                                @click="$inertia.visit(route('dashboard.plans.edit', customer.plan.id))">
                                Haga click aqui
                            </PrimaryButton>
                        </p>
                    </template>
                </template>

                <template #form>
                    <SelectForm v-model="form.service_id" text="Service" name="service_id">
                        <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="form.period" text="Period">
                        <option value="" disabled selected>Select a option</option>
                        <option v-for="price in prices" :value="price.period">
                            {{ price.period_label }} - C$ {{ price.value }}
                        </option>
                    </SelectForm>
                    <InputForm text="Start Date" v-model="form.start_date" type="date"></InputForm>

                    <div class="col-span-4  font-medium text-gray-900">
                        Last day: <span class="badge-danger text-sm">{{ end_date_label }}</span>
                    </div>
                    <InputForm text="Discount" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Note" v-model="form.note"></InputForm>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        <h3>
                            Total: C$ {{ total }}
                        </h3>
                    </div>
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
import FormSection from '@/Components/FormSection.vue';
import { router, useForm } from '@inertiajs/vue3';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import { watch, ref, computed } from 'vue';
import { Carbon } from '@/Classes/Carbon.js';
import { toast } from '@/Use/toast.js';
import { Link } from '@inertiajs/vue3';
import { calculateTotal, watchForPrices } from '@/Use/helpers.js';

const props = defineProps({
    customer: {
        type: Object, required: false
    },
    isNew: {
        type: Boolean, default: true
    },
    services: {
        type: Object, required: true
    }
})

const prices = ref([])
const today = new Carbon().format('Y-m-d');

const form = useForm({
    id: props.customer?.id ?? null,
    name: props.customer?.name ?? '',
    phone: props.customer?.phone ?? '',
    birth_date: props.customer?.birth_date ?? '',
    gender: props.customer?.gender ?? 'F',

    amount: props.customer?.plan?.amount ?? 0,
    period: props.customer?.plan?.period ?? null,
    start_date: props.customer?.plan?.start_date ?? today,
    end_date: props.customer?.plan?.end_date ?? null,
    discount: props.customer?.plan?.discount ?? 0,
    note: props.customer?.plan?.note ?? '',
    service_id: props.customer?.plan?.service_id ?? props.services[0].id,
});

const total = computed(() => {
    return calculateTotal({period: form.period, discount: form.discount }, prices.value);
});

watchForPrices(form, props.services, prices);

const end_date = computed(() => {
    return Carbon.create(form.start_date).addPeriod(parseInt(form.period)).format('Y-m-d');
});

const end_date_label = computed(() => {
    return Carbon.simpleFormat(end_date.value);
});

function saveCustomer() {
    form.amount = total.value;
    form.end_date = end_date.value;

    if (props.isNew) {
        form.post(route('dashboard.customers.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Customer created successfully!');
                router.get(route('dashboard.customers.index'));
            },
        });
    } else {
        form.put(route('dashboard.customers.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Customer updated successfully!');
                router.get(route('dashboard.customers.index'));
            },
        });
    }
}

</script>
