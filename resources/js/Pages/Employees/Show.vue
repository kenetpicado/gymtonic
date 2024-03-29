<template>
    <AppLayout title="Pagos" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                Nuevo
            </template>
            <template #content>
                <InputForm text="Concepto" name="concept" v-model="form.concept"></InputForm>
                <InputForm text="Descripcion (opcional)" name="description" v-model="form.description"></InputForm>
                <InputForm text="Monto" name="value" v-model="form.value" type="number"></InputForm>
                <InputForm text="Fecha" name="created_at" v-model="form.created_at" type="date"></InputForm>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton payment="button" @click="save">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>

            <template #topbar>
                <h2 class="text-2xl font-extrabold text-gray-600">
                    Pagos: {{ employee.name }}
                </h2>
                <PrimaryButton payment="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(payment, index) in payments.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="payment.created_at" />
                    </td>
                    <td>
                        {{ payment.concept }}
                    </td>
                    <td>
                        {{ payment.description }}
                    </td>
                    <td>
                        <span class="badge-blue">C$ {{ payment.value.toLocaleString('en-US') }}</span>
                    </td>
                    <td>
                        <IconPencil @click="edit(payment)" role="button" />
                    </td>
                </tr>
                <tr v-if="payments.data.length == 0">
                    <td colspan="5" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="payments.links"></ThePaginator>
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from "@/Use/toast.js";
import TableSection from '@/Components/TableSection.vue';
import { Carbon } from '@/Classes/Carbon.js';
import ThePaginator from '@/Components/ThePaginator.vue';
import DateColumn from '@/Components/DateColumn.vue';
import { IconPencil } from '@tabler/icons-vue';

const props = defineProps({
    employee: {
        payment: Object, required: true
    },
    payments: {
        payment: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Personal', route: 'dashboard.employees.index' },
    { name: 'Pagos', route: 'dashboard.employees.show', params: [props.employee.id] },
]

const form = useForm({
    id: null,
    value: 0,
    quantity: 1,
    description: '',
    concept: 'Pago de salario',
    expenditureable_type: 'App\\Models\\Employee',
    expenditureable_id: props.employee.id,
    created_at: Carbon.today(),
})

function edit(payment) {
    isNew.value = false;
    form.id = payment.id;
    form.value = payment.value;
    form.quantity = payment.quantity;
    form.description = payment.description;
    form.concept = payment.concept;
    form.created_at = new Carbon(payment.created_at).format('Y-m-d');
    openModal.value = true;
}

function save() {
    if (isNew.value) {
        form.post(route('dashboard.expenditures.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                toast.success('Pago guardado correctamente!');
            },
        });
    } else {
        form.put(route('dashboard.expenditures.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                toast.success('Pago actualizado correctamente!');
            },
        });
    }
}

function resetValues() {
    form.reset();
    form.clearErrors();
    isNew.value = true;
    openModal.value = false;
}

</script>
