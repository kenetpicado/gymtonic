<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ employee.name }} | Payments
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <!-- <template #title>
                New Payment
            </template>
            <template #content>
                <InputForm text="Value" v-model="form.value"></InputForm>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancel
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveWeight">
                    Save
                </PrimaryButton>
            </template> -->
        </DialogModal>


        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Concept</th>
                <th>Amount</th>
            </template>

            <template #body>
                <tr v-for="(payment, index) in employee.payments" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <div class="font-medium mb-1">
                            <span class="text-gray-700">{{ payment.created_at_formatted }}</span>
                            <span class="text-gray-400"> ({{ diffForHumans(payment.created_at) }})</span>
                        </div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-700 mb-1">
                                {{ payment.concept }}
                            </div>
                            <div class="text-gray-400" v-if="payment.description">
                                {{ payment.description }}
                            </div>
                        </div>
                    </td>
                    <td>
                        C$ {{ payment.amount.toLocaleString('en-US') }}
                    </td>
                </tr>
                <tr v-if="employee.payments.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
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
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import useNotify from '@/Use/notify.js';
import TableSection from '@/Components/TableSection.vue';
import useHumanDate from '@/Composables/useHumanDate';

const props = defineProps({
    employee: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const notify = useNotify();
const isNew = ref(true);
const { diffForHumans } = useHumanDate();

const form = useForm({
    value: null,
    employee_id: props.employee.id,
})

function saveWeight() {
    if (isNew.value) {
        form.post(route('dashboard.weights.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                notify.success('Weight added successfully');
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

async function editWeight(weight) {
    form.id = weight.id;
    form.value = weight.value;
    isNew.value = false;
    openModal.value = true;
}

function removeWeight(id) {
    notify.confirm(() => {
        router.delete(route('dashboard.weights.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Weight deleted successfully');
            },
        });
    }, 'Are you sure you want to delete this weight?');
}

function resetValues() {
    form.reset();
    openModal.value = false;
    isNew.value = true;
}

</script>