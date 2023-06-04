<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ employee.name }} | Payments
            </h2>
            <div>
                <PrimaryButton payment="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Payment
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Amount" v-model="form.amount"></InputForm>
                    <InputForm text="Description (optional)" v-model="form.description"></InputForm>
                    <InputForm text="Date" v-model="form.created_at" payment="date"></InputForm>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancel
                </SecondaryButton>
                <PrimaryButton payment="button" @click="savePayment">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Date</th>
                <th>Concept</th>
                <th>Amount</th>
            </template>

            <template #body>
                <tr v-for="(payment, index) in payments.data" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
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
                </tr>
                <tr v-if="payments.data.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
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
import useNotify from '@/Use/notify.js';
import TableSection from '@/Components/TableSection.vue';
import { Datep } from '@/Classes/Datep.js';
import ThePaginator from '@/Components/ThePaginator.vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    employee: {
        payment: Object, required: true
    },
    payments: {
        payment: Object, required: true
    }
})

const openModal = ref(false)
const notify = useNotify();
const isNew = ref(true);

const form = useForm({
    amount: 0,
    description: '',
    concept: 'Pago de salario',
    expenditureable_payment: 'App\\Models\\Employee',
    expenditureable_id: props.employee.id,
    created_at: new Datep().format('Y-m-d'),
})

function savePayment() {
    if (isNew.value) {
        form.post(route('dashboard.expenditures.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                notify.success('Payment added successfully');
            },
        });
    } else {
        form.put(route('dashboard.weights.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                notify.success('Weight updated successfully');
            },
        });
    }
}

function resetValues() {
    form.reset();
    isNew.value = true;
    openModal.value = false;
}

</script>