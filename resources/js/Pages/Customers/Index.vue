<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import useProfileUrl from '@/Composables/useProfileUrl.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue';

const props = defineProps({
    customers: {
        type: Object, required: true
    }
})

const profileUrl = useProfileUrl();

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Customers
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.customers.create'))">
                    New
                </PrimaryButton>
            </div>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-end">
                    <SearchComponent :url="route('dashboard.customers.index')" :only="['customers']"></SearchComponent>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="(customer, index) in customers.data" class="hover:bg-gray-50">
                                    <td>
                                        {{ index + 1 }}
                                    </td>
                                    <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                                        <div class="h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center"
                                                :src="profileUrl.get(customer.name)" alt="" />
                                        </div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ customer.name }}</div>
                                            <div class="text-gray-400">{{ customer.phone ?? 'No phone' }}</div>
                                        </div>
                                    </th>
                                    <td>
                                        <span
                                            :class="{ 'badge-blue': customer.gender == 'M', 'badge-pink': customer.gender == 'F' }">
                                            {{ customer.gender }}
                                        </span>
                                    </td>
                                    <td>{{ customer.age }}</td>
                                    <td>
                                        <span v-if="customer.plan_count > 0" class="badge-success">
                                            <span class="dot-green"></span>
                                            Active
                                        </span>
                                        <span v-else class="badge-gray">
                                            <span class="dot-gray"></span>
                                            Inactive
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-eye mr-3" role="button"
                                            @click="$inertia.visit(route('dashboard.customers.show', customer.id))"></i>
                                        <i class="fas fa-edit mr-3" role="button"
                                            @click="$inertia.visit(route('dashboard.customers.edit', customer.id))"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ThePaginator :links="customers.links"></ThePaginator>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
