<template>
    <AppLayout title="Dashboard" :breads="breads">
        <TableSection>
            <template #topbar>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                    Historial: {{ customer.name }}
                </h2>
            </template>

            <template #header>
                <th>Transaccion</th>
                <th>Concepto</th>
                <th>Descripcion</th>
                <th>Fecha</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in customer.incomes" class="hover:bg-gray-50">
                    <td>
                        #{{ income.id }}
                    </td>
                    <th>
                        {{ income.concept }}
                    </th>
                    <td>
                        {{ income.description }}
                    </td>
                    <td>
                        <DateColumn :date="income.created_at" />
                    </td>
                </tr>
                <tr v-if="customer.incomes.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    customer: {
        type: Object, required: true
    }
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
    { name: 'Ver', route: 'dashboard.customers.show', params: [ props.customer.id ] },
]

</script>