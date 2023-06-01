<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Incomes
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.incomes.create'))">
                    New
                </PrimaryButton>
            </div>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-end mb-4">
                    <SearchComponent :url="route('dashboard.customers.index')" :only="['customers']"></SearchComponent>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Concept</th>
                                    <th>Amount</th>
                                    <th>Quantity</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Created</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="(income, index) in incomes.data" class="hover:bg-gray-50">
                                    <td>
                                        {{ income.id }}
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ income.concept }}</div>
                                            <div class="text-gray-400">{{ income.description ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        C$ {{ income.amount }}
                                    </td>
                                    <td>
                                        {{ income.quantity }}
                                    </td>
                                    <td>
                                        <span v-if="income.discount">C$ {{ income.discount }}</span>
                                    </td>
                                    <td>
                                        C$ {{ income.amount * income.quantity - income.discount }}
                                    </td>
                                    <td>
                                        {{ income.created_at }}
                                    </td>
                                </tr>
                                <tr v-if="incomes.data.length == 0">
                                    <td colspan="6" class="text-center">No data to display</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ThePaginator :links="incomes.links"></ThePaginator>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue';

const props = defineProps({
    incomes: {
        type: Object, required: true
    }
})

</script>
