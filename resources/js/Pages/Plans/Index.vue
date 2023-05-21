<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import useProfileUrl from '@/Composables/useProfileUrl.js';

const props = defineProps({
    plans: {
        type: Object, required: true
    }
})

const profileUrl = useProfileUrl();

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Plans
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.customers.create'))">
                    New
                </PrimaryButton>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Period</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="plan in plans.data" class="hover:bg-gray-50">
                                    <td>
                                        {{ plan.id }}
                                    </td>
                                    <td class="flex gap-3 font-normal text-gray-900 items-center">
                                        <div class="h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center"
                                                :src="profileUrl.get(plan.customer.name)" alt="" />
                                        </div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ plan.customer.name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ plan.service.name }}
                                        <div class="text-sm mt-1">
                                            ({{ plan.period }} days)
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-gray">
                                            {{ plan.start_date_formated }}
                                        </span>
                                        <span class="badge-blue">
                                            {{ plan.end_date_formated }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-success">
                                            <span class="dot-green"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-edit mr-3" role="button"
                                            @click="$inertia.visit(route('dashboard.customers.edit', plan.customer.id))"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ThePaginator :links="plans.links"></ThePaginator>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
