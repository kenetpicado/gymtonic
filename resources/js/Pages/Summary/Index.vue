<template>
    <AppLayout title="Dashboard" :breads="breads">

        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Mes</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Ganacia</th>
            </template>

            <template #body>
                <tr v-for="month in monthList" class="hover:bg-gray-50" >
                    <td>
                        {{ month.id }}
                    </td>
                    <td>
                        {{ month.name }}
                        <span v-if="MONTH == month.name" class="font-bold">
                            (ACTUAL)
                        </span>
                    </td>
                    <td>
                        <span class="badge-success">
                            {{ findIncome(month.id) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-danger">
                            {{ findExpenditure(month.id) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge-blue">
                            {{ getRenevue(month.id) }}
                        </span>
                    </td>
                </tr>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import { Carbon } from '@/Classes/Carbon.js';

const props = defineProps({
    incomes: {
        type: Object, required: true
    },
    expenditures: {
        type: Object,
        required: true
    },
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Resumen', route: 'dashboard.summary.index' },
]

const MONTH = new Carbon().monthName()

const monthList = [
    { id: 1, name: 'Enero' },
    { id: 2, name: 'Febrero' },
    { id: 3, name: 'Marzo' },
    { id: 4, name: 'Abril' },
    { id: 5, name: 'Mayo' },
    { id: 6, name: 'Junio' },
    { id: 7, name: 'Julio' },
    { id: 8, name: 'Agosto' },
    { id: 9, name: 'Septiembre' },
    { id: 10, name: 'Octubre' },
    { id: 11, name: 'Noviembre' },
    { id: 12, name: 'Diciembre' },
]

function findIncome(month) {
    const income = props.incomes.find(income => income.month === month)

    if (income) {
        return 'C$ ' + income.total.toLocaleString()
    }

    return 'C$ 0'
}

function findExpenditure(month) {
    const expenditure = props.expenditures.find(expenditure => expenditure.month === month)

    if (expenditure) {
        return 'C$ ' + expenditure.total.toLocaleString()
    }

    return 'C$ 0'
}

function getRenevue(month) {
    const income = props.incomes.find(income => income.month === month)
    const expenditure = props.expenditures.find(expenditure => expenditure.month === month)

    if (income && expenditure) {
        return 'C$ ' + (income.total - expenditure.total).toLocaleString()
    }

    return 'C$ 0'
}

</script>
