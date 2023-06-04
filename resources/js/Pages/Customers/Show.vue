<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ customer.name }} | Weights
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Weight
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
            </template>
        </DialogModal>

        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Date</th>
                <th>Weight (lbs)</th>
                <th>Actions</th>
            </template>

            <template #body>
                <tr v-for="(weight, index) in customer.weights" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <DateColumn :date="weight.created_at" />
                    </td>
                    <td>
                        <span class="badge-blue">
                            {{ weight.value }} lbs
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <IconPencil @click="editWeight(weight)" role="button"/>

                            <IconTrash @click="removeWeight(weight.id)" role="button"/>
                        </div>
                    </td>
                </tr>
                <tr v-if="customer.weights.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TableSection from '@/Components/TableSection.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import useNotify from '@/Use/notify.js';
import { router, useForm } from '@inertiajs/vue3';
import { IconPencil, IconTrash } from '@tabler/icons-vue';
import { ref } from 'vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    customer: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const notify = useNotify();
const isNew = ref(true);

const form = useForm({
    value: null,
    customer_id: props.customer.id,
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