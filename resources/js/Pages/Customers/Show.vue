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
                <SecondaryButton @click="openModal = false">
                    Cancel
                </SecondaryButton>
                <PrimaryButton type="button" @click="submit">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Weight (lbs)</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="(weight, index) in customer.weights" class="hover:bg-gray-50">
                                    <td>
                                        {{ index + 1 }}
                                    </td>
                                    <td>
                                        <span class="badge-blue">
                                            {{ weight.value }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ weight.created_at_format }}
                                        <div class="text-sm mt-1">
                                            ({{ weight.created_at_humman }})
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-edit mr-3" role="button" @click="editWeight(weight)"></i>
                                        <i class="fas fa-trash mr-3" role="button" @click="removeWeight(weight.id)"></i>
                                    </td>
                                </tr>
                                <tr v-if="customer.weights.length == 0">
                                    <td colspan="4" class="text-center">No data to display</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
import axios from 'axios';

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

function submit() {
    if (isNew.value) {
        form.post(route('dashboard.weights.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                openModal.value = false;
                form.reset();
                notify.success('Weight added successfully');
            },
        });
    } else {
        form.put(route('dashboard.weights.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                openModal.value = false;
                isNew.value = true;
                form.reset();
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

</script>