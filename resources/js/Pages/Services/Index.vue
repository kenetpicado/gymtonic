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
                <label class="flex items-center mt-3 mb-4">
                    <Checkbox v-model:checked="form.is_active" name="is_active" />
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </label>
                <h4>Prices</h4>
                <p class="text-sm text-red-600 mt-1" v-if="$page.props.errors['prices']">
                    {{ $page.props.errors['prices'] }}
                </p>

                <InputForm v-for="(period, index) in form.prices" :name="`prices.${index}.value`"
                    :text="period.period_label" v-model="period.value" class="mt-4" type="number"></InputForm>
            </template>
            <template #footer>
                <SecondaryButton @click="closeModal">
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
                                    <th>Prices</th>
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
                                        <span v-for="price in service.prices" class="badge-blue mr-1">
                                            {{ price.period_label }}: C$ {{ price.value }}
                                        </span>
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
                                        <i class="fas fa-edit mr-3" role="button" @click="edit(service)"></i>
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
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import useNotify from '@/Use/notify.js';

const props = defineProps({
    services: {
        type: Object, required: true
    },
    periods: {
        type: Array,
        required: true
    }
})

const notify = useNotify()
const openModal = ref(false)
const isNew = ref(true)

const form = useForm({
    id: null,
    name: '',
    is_active: true,
    prices: props.periods,
});

async function edit(service) {
    form.id = service.id
    form.name = service.name
    form.is_active = Boolean(service.is_active)
    isNew.value = false

    form.prices = props.periods.map(({ period_label, period }) => ({
        period_label, period, value: service.prices.find(price => price.period == period)?.value || null
    }));

    openModal.value = true
}

function onSuccessSubmit() {
    form.id = null
    form.name = ''
    form.is_active = true
    form.prices = props.periods
    isNew.value = true
    openModal.value = false
}

function closeModal() {
    onSuccessSubmit()
}

function submit() {
    form.prices = form.prices.filter(period => period.value)

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
