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
                    <div>
                        <div class="flex justify-center">
                            <div class="w-1/2 my-6">
                                <canvas id="myChart" style="width: 100%;"></canvas>
                            </div>
                        </div>
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
                                    <tr v-for="weight in customer.weights" class="hover:bg-gray-50">
                                        <td>
                                            {{ weight.id }}
                                        </td>
                                        <td>
                                            <span class="badge-blue">
                                                {{ weight.value }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ weight.created_at }}
                                        </td>
                                        <td>

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
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
    customer: {
        type: Object, required: true
    }
})

const openModal = ref(false)

const form = useForm({
    value: null,
    customer_id: props.customer.id,
})

function submit() {
    form.post(route('dashboard.weights.store'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            openModal.value = false;
            form.reset();
        },
    });
}

const labels = props.customer.weights.map(weight => weight.created_at).slice(0, 6).reverse();
const data = props.customer.weights.map(weight => weight.value).slice(0, 6).reverse();

onMounted(() => {
    new Chart(document.getElementById('myChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                fill: false,
                borderColor: '#4f46e5',
                tension: 0.1,
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
})

</script>