<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ employee.name }} | Pagos
            </h2>
            <div>
                <PrimaryButton payment="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                Nuevo Pago
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Amount" v-model="form.amount"></InputForm>
                    <InputForm text="Description (optional)" v-model="form.description"></InputForm>
                    <InputForm text="Date" v-model="form.created_at" type="date"></InputForm>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton payment="button" @click="savePayment">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #header>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(payment, index) in payments.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="payment.created_at"/>
                    </td>
                    <th>
                        <div class="text-sm">
                            <div class="font-medium text-gray-700 mb-1">
                                {{ payment.concept }}
                            </div>
                            <div class="text-gray-400" v-if="payment.description">
                                {{ payment.description }}
                            </div>
                        </div>
                    </th>
                    <td>
                        <span class="badge-blue">C$ {{ payment.amount.toLocaleString('en-US') }}</span>
                    </td>
                    <td>
                        <IconPencil @click="editPayment(payment)" role="button"/>
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

const form = useForm({
    amount: 0,
    description: '',
    concept: 'Pago de salario',
    expenditureable_type: 'App\\Models\\Employee',
    expenditureable_id: props.employee.id,
    created_at: Carbon.today(),
})

function editPayment(payment) {
    isNew.value = false;
    form.id = payment.id;
    form.amount = payment.amount;
    form.description = payment.description;
    form.concept = payment.concept;
    form.created_at = new Carbon(payment.created_at).format('Y-m-d');
    openModal.value = true;
}

function savePayment() {
    if (isNew.value) {
        form.post(route('dashboard.expenditures.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                toast.success('Pago guardado correctamente!');
            }
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