<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Expenditures
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.expenditures.create'))">
                    New
                </PrimaryButton>
            </div>
        </template>

        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.expenditures.index')" :only="['expenditures']"></SearchComponent>
            </template>

            <template #header>
                <th>ID</th>
                <th>Model</th>
                <th>Concept</th>
                <th>Amount</th>
                <th>Total</th>
            </template>

            <template #body>
                <tr v-for="(expenditure, index) in expenditures.data" class="hover:bg-gray-50">
                    <td>
                        {{ expenditure.id }}
                    </td>
                    <td>
                        <!-- <UserInformation v-if="expenditure.expenditureable_type == 'App\\Models\\Customer'"
                            :user="expenditure.expenditureable" /> -->
                    </td>
                    <td>
                        <div class="text-sm">
                            <div class="font-medium text-gray-700 mb-1">{{ expenditure.created_at }} - {{ expenditure.concept }}</div>
                            <div class="text-gray-400" v-if="expenditure.description">{{ expenditure.description }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">C$ {{ expenditure.amount }}</div>
                        <div class="text-gray-400" v-if="expenditure.quantity > 1">
                            Quantity: {{ expenditure.quantity }}
                        </div>
                    </td>
                    <td>
                        C$ {{ expenditure.amount * expenditure.quantity }}
                    </td>
                </tr>
                <tr v-if="expenditures.data.length == 0">
                    <td colspan="6" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="expenditures.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';

const props = defineProps({
    expenditures: {
        type: Object, required: true
    }
})

</script>
