<template>
    <AppLayout title="Dashboard" :breads="breads">
        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.incomes.index')" :only="['incomes']"></SearchComponent>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.incomes.create'))">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Description</th>
                <th>Monto</th>
                <th>Total</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in incomes.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="income.created_at" />
                    </td>
                    <td>
                        <UserInformation v-if="income.incomeable_type == 'App\\Models\\Customer'"
                            :user="income.incomeable" />

                        <ConceptInformation v-if="income.incomeable_type == 'App\\Models\\Concept'"
                            :concept="income.incomeable" />

                        <span v-if="!income.incomeable_type">
                            {{ income.concept }}
                        </span>
                    </td>
                    <td>
                         {{ income.description }}
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ (income.value + income.discount).toLocaleString('en-US') }}
                        </div>
                        <div class="text-red-400 mt-1 text-xs" v-if="income.discount">
                            -C$ {{ income.discount.toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="income.quantity > 1">
                            cant. {{ income.quantity }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-blue">
                            C$ {{ (income.value * income.quantity).toLocaleString('en-US') }}
                        </span>
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
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import ConceptInformation from '@/Components/ConceptInformation.vue';
import ConceptInfo from '@/Components/ConceptInfo.vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    incomes: {
        type: Object, required: true
    },
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Ingresos', route: 'dashboard.incomes.index' },
]

</script>
