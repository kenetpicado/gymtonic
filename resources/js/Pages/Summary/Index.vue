<template>
    <AppLayout title="Dashboard" :breads="breads">

        <TableSection>
            <template #topbar>
                <SelectForm v-model="queryParams.model_id" text="Model">
                    <option selected value="">Todos</option>
                    <option v-for="concept in concepts" :value="concept.id">{{ concept.name }}</option>
                </SelectForm>
            </template>

            <template #header>
                <th>ID</th>
                <th>Mes</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Ganacia</th>
            </template>

            <template #body>
                <tr v-for="month in monthList.slice(0, MONTH)" class="hover:bg-gray-50">
                    <td>
                        {{ month.id }}
                    </td>
                    <td>
                        {{ month.name }}
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
                        <span :class="[ getRenevue(month.id).includes('-') ? 'badge-danger' : 'badge-blue']">
                            {{ getRenevue(month.id) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="font-bold">Total</td>
                    <td class="font-bold">C$ {{ totalIncome.toLocaleString() }}</td>
                    <td class="font-bold">C$ {{ totalExpenditure.toLocaleString()  }}</td>
                    <td class="font-bold">C$ {{ (totalIncome - totalExpenditure).toLocaleString() }}</td>
                </tr>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import { Carbon } from '@/Classes/Carbon.js';
import SelectForm from '@/Components/Form/SelectForm.vue'
import { ref, watch, reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3';

const props = defineProps({
    incomes: {
        type: Object, required: true
    },
    expenditures: {
        type: Object,
        required: true
    },
    concepts: {
        type: Object,
        required: true
    },
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Resumen', route: 'dashboard.summary.index' },
]

const MONTH = new Carbon().month()

const queryParams = reactive({
    model_id: '',
})

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
    const income = props.incomes.find(income => income.month === month)?.total ?? 0
    const expenditure = props.expenditures.find(expenditure => expenditure.month === month)?.total ?? 0

    return 'C$ ' + (income - expenditure).toLocaleString()
}

const totalIncome = computed(() => props.incomes.reduce((acc, income) => acc + income.total, 0));

const totalExpenditure = computed(() => props.expenditures.reduce((acc, expenditure) => acc + expenditure.total, 0));

watch(() => queryParams.model_id, (value) => {
    getFilteredSummary()
})

function getFilteredSummary() {
    if (queryParams.model_id === '') {
        delete queryParams.model_id;
    }

    router.get(route('dashboard.summary.index'), queryParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['incomes', 'expenditures'],
        replace: true,
    });
}

</script>