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

        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.incomes.index')" :only="['incomes']"></SearchComponent>
            </template>

            <template #header>
                <th>ID</th>
                <th>Model</th>
                <th>Concept</th>
                <th>Amount</th>
                <th>Total</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in incomes.data" class="hover:bg-gray-50">
                    <td>
                        {{ income.id }}
                    </td>
                    <td>
                        <UserInformation v-if="income.incomeable_type == 'App\\Models\\Customer'"
                            :user="income.incomeable" />
                    </td>
                    <td>
                        <div class="text-sm">
                            <div class="font-medium text-gray-700 mb-1">{{ income.created_at }} - {{ income.concept }}</div>
                            <div class="text-gray-400" v-if="income.description">{{ income.description }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">C$ {{ income.amount }}</div>
                        <div class="text-red-400 mt-1" v-if="income.discount">
                            Discount: C$ {{ income.discount }}
                        </div>
                        <div class="text-gray-400" v-if="income.quantity > 1">
                            Quantity: {{ income.quantity }}
                        </div>
                    </td>
                    <td>
                        C$ {{ income.amount * income.quantity }}
                    </td>
                </tr>
                <tr v-if="incomes.data.length == 0">
                    <td colspan="6" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="incomes.links"></ThePaginator>
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
    incomes: {
        type: Object, required: true
    }
})

</script>
