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
                <th>Model</th>
                <th>Concept</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Date</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in incomes.data" class="hover:bg-gray-50">
                    <td>
                        <span v-if="!income.incomeable_type" class="text-sm text-gray-400 italic">
                            None
                        </span>
                        <UserInformation v-if="income.incomeable_type == 'App\\Models\\Customer'"
                            :user="income.incomeable" />
                    </td>
                    <td>
                        <ConceptInfo :type="income" />
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ income.amount.toLocaleString('en-US') }}
                        </div>
                        <div class="text-red-400 mt-1 text-xs" v-if="income.discount">
                            -C$ {{ income.discount.toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="income.quantity > 1">
                            Qty: {{ income.quantity }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-blue">
                            C$ {{ (income.amount * income.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                    <td>
                        <DateColumn :date="income.created_at" />
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
import ConceptInfo from '@/Components/ConceptInfo.vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    incomes: {
        type: Object, required: true
    }
})

</script>
