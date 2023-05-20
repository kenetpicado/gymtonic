<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Services
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Service
            </template>
            <template #content>
                <InputForm text="Name" v-model="form.name"></InputForm>
                <label class="flex items-center mt-3">
                    <Checkbox v-model:checked="form.is_active" name="is_active" />
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
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

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="service in services.data" class="hover:bg-gray-50">
                                    <td>
                                        {{ service.id }}
                                    </td>
                                    <td>
                                        {{ service.name }}
                                    </td>
                                    <td>
                                        <span v-if="service.is_active" class="badge-success">
                                            <span class="dot-green"></span>
                                            Active
                                        </span>
                                        <span v-else class="badge-gray">
                                            <span class="dot-gray"></span>
                                            Inactive
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-edit mr-3" role="button" @click="edit(service.id)"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ThePaginator :links="services.links"></ThePaginator>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import { defineProps, ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';
import Checkbox from '@/Components/Checkbox.vue';
import useNotify from '@/Use/notify.js';

const props = defineProps({
    services: {
        type: Object, required: true
    },
    service: {
        type: Object,
        required: false,
    }
})

const openModal = ref(false)
const isNew = ref(true)
const notify = useNotify()

const form = useForm({
    id: props.service?.id ?? null,
    name: props.service?.name ?? '',
    is_active: props.service?.name ?? true,
});

async function edit(id) {
    const response = await axios.get(route('dashboard.services.edit', id))
    form.id = response.data.id
    form.name = response.data.name
    form.is_active = Boolean(response.data.is_active)
    isNew.value = false
    openModal.value = true
}

function onSuccessSubmit() {
    openModal.value = false
    form.reset()
    isNew.value = true
}

function submit() {
    if (isNew.value) {
        form.post(route('dashboard.services.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Service created successfully')
                onSuccessSubmit()
            },
        });
    } else {
        form.put(route('dashboard.services.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Service updated successfully')
                onSuccessSubmit()
            },
        });
    }
}

</script>
