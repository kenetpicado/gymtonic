<template>
    <AppLayout title="Customer" :breads="breads">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="saveCustomer">
                <template #title>
                    Informacion del Cliente
                </template>

                <template #description>
                    Datos personales del cliente
                </template>

                <template #form>
                    <InputForm text="Name" v-model="form.name"></InputForm>
                    <InputForm text="Phone" v-model="form.phone" type="number"></InputForm>
                    <InputForm text="Birth Date" v-model="form.birth_date" type="date"></InputForm>
                    <SelectForm v-model="form.gender" text="Gender">
                        <option value="F">Femenino</option>
                        <option value="M">Masculino</option>
                    </SelectForm>
                </template>

                <template #actions>
                    <Link :href="route('dashboard.customers.index')">
                    <SecondaryButton>
                        Cancelar
                    </SecondaryButton>
                    </Link>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                </template>
            </FormSection>

            <SectionBorder />

            <FormSection @submitted="saveCustomer">
                <template #title>
                    Informacion del Plan
                </template>

                <template #description>
                    <template v-if="customer">
                        <div v-if="!customer.plan">
                            El usuario no tiene un plan creado, se procederá a crear uno nuevo con los datos ingresados.
                        </div>
                        <div v-else>
                            El usuario tiene un plan existente, se actualizará con los datos introducidos y también se
                            actualizará el ingreso correspondiente.
                            <span class="block mt-2"></span>
                            Si en cambio desea crear un nuevo plan
                            <br>
                            <PrimaryButton class="mt-4"
                                @click="$inertia.visit(route('dashboard.plans.edit', customer.plan.id))">
                                Haga click aqui
                            </PrimaryButton>
                        </div>
                    </template>
                    <div v-else>
                        Ingrese los datos del plan para el cliente.
                    </div>
                </template>

                <template #form>
                    <SelectForm v-model="form.service_id" text="Service" name="service_id">
                        <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="form.period" text="Period">
                        <option value="" disabled selected>Select a option</option>
                        <option v-for="price in prices" :value="price.period">
                            {{ periodLabel[price.period] }} - C$ {{ price.value }}
                        </option>
                    </SelectForm>
                    <InputForm text="Start Date" v-model="form.start_date" type="date"></InputForm>
                    <InputForm text="End Date" v-model="end_date" type="date" disabled></InputForm>
                    <InputForm text="Discount" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Note" v-model="form.note"></InputForm>

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
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import { router, useForm } from '@inertiajs/vue3';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import { ref, computed } from 'vue';
import { Carbon } from '@/Classes/Carbon.js';
import { toast } from '@/Use/toast.js';
import { Link } from '@inertiajs/vue3';
import { calculateTotal, watchForPrices } from '@/Use/helpers.js';
import { Plan } from '@/Classes/Plan';
import { periodLabel } from '@/Use/periodLabel';

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

const form = useForm({
    id: props.customer?.id ?? null,
    name: props.customer?.name ?? '',
    phone: props.customer?.phone ?? '',
    birth_date: props.customer?.birth_date ?? '',
    gender: props.customer?.gender ?? 'F',
    ...new Plan(props.customer?.plan, props.services[0].id),
});

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
    { name: props.isNew ? 'Crear' : 'Editar', route: 'dashboard.customers.create' },
]

const total = computed(() => {
    return calculateTotal({ period: form.period, discount: form.discount }, prices.value);
});

watchForPrices(form, props.services, prices);

const end_date = computed(() => {
    return Carbon.create(form.start_date).addPeriod(parseInt(form.period)).addDays(-1).format();
});

function saveCustomer() {
    form.price = total.value;
    form.end_date = end_date.value;

    if (props.isNew) {
        form.post(route('dashboard.customers.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Cliente creado correctamente!');
                router.get(route('dashboard.customers.index'));
            }
        });
    } else {
        form.put(route('dashboard.customers.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Cliente actualizado correctamente!');
                router.get(route('dashboard.customers.index'));
            },
        });
    }
}

</script>
