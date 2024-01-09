<template>
    <AppLayout title="Dashboard" :breads="breads">

        <TableSection>
            <template #topbar>
                <h1 class="text-2xl font-extrabold text-gray-600 col-span-2">
                    Resumen
                </h1>
            </template>

            <template #filters>
                <div class="grid grid-cols-4 mb-6 gap-4">
                    <SelectForm v-model="queryParams.model_id" text="Concepto">
                        <option selected value="">Todos</option>
                        <option v-for="concept in concepts" :value="concept.id">{{ concept.name }}</option>
                    </SelectForm>
                    <SelectForm v-model="queryParams.year" text="Año">
                        <option value="">Año en curso</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </SelectForm>
                </div>
            </template>

            <template #header>
                <th>ID</th>
                <th>Mes</th>
                <th>Clientes <br> registrados</th>
                <th>Planes <br> contratados (aprox.)</th>
                <th>Ingresos</th>
                <th>Egresos</th>
                <th>Ganacia</th>
            </template>

            <template #body>
                <template v-for="month in monthList">
                    <tr v-if="showRow(month.id)" class="hover:bg-gray-50">
                        <td>
                            {{ month.id }}
                        </td>
                        <td>
                            {{ month.name }}
                        </td>
                        <td>
                            {{ clients.find(client => client.month === month.id)?.total ?? 0 }}
                        </td>
                        <td>
                            {{ plans.find(plan => plan.month === month.id)?.total ?? 0 }}
                        </td>
                        <td>
                            <span class="badge-success">
                                {{ findValue(month.id, 'income') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-danger">
                                {{ findValue(month.id, 'expenditure') }}
                            </span>
                        </td>
                        <td>
                            <span :class="[getRenevue(month.id).includes('-') ? 'badge-danger' : 'badge-blue']">
                                {{ getRenevue(month.id) }}
                            </span>
                        </td>
                    </tr>
                </template>
                <tr class="bg-gray-50">
                    <td></td>
                    <td class="font-bold">Total</td>
                    <td>
                        {{ clients.reduce((acc, client) => acc + client.total, 0) }}
                    </td>
                    <td>
                        {{ plans.reduce((acc, plan) => acc + plan.total, 0) }}
                    </td>
                    <td class="font-bold">C$ {{ totalIncome.toLocaleString() }}</td>
                    <td class="font-bold">C$ {{ totalExpenditure.toLocaleString() }}</td>
                    <td class="font-bold">C$ {{ (totalIncome - totalExpenditure).toLocaleString() }}</td>
                </tr>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import SelectForm from '@/Components/Form/SelectForm.vue'
import { watch, reactive, computed } from 'vue'
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
    clients: {
        type: Object,
        required: true
    },
    plans: {
        type: Object,
        required: true
    },
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Resumen', route: 'dashboard.summary.index' },
]

const searchParams = new URLSearchParams(window.location.search)

const queryParams = reactive({
    model_id: searchParams.get('model_id') ?? '',
    year: searchParams.get('year') ?? '',
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

function findValue(month, type) {
    const data = type === 'income' ? props.incomes : props.expenditures;
    const item = data.find(entry => entry.month === month);

    return item
        ? `C$ ${item.total?.toLocaleString() ?? 0}`
        : 'C$ 0';
}

function showRow(month) {
    return props.incomes.some(income => income.month === month) || props.expenditures.some(expenditure => expenditure.month === month);
}

function getRenevue(month) {
    const income = props.incomes.find(income => income.month === month)?.total ?? 0
    const expenditure = props.expenditures.find(expenditure => expenditure.month === month)?.total ?? 0

    return 'C$ ' + (income - expenditure).toLocaleString()
}

const totalIncome = computed(() => props.incomes.reduce((acc, income) => acc + income.total, 0));
const totalExpenditure = computed(() => props.expenditures.reduce((acc, expenditure) => acc + expenditure.total, 0));

watch(queryParams, getFilteredSummary, { deep: true })

function getFilteredSummary() {
    for (const key in queryParams) {
        if (queryParams[key] === '') {
            delete queryParams[key]
        }
    }

    router.get(route('dashboard.summary.index'), queryParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['incomes', 'expenditures', 'clients', 'plans'],
        replace: true,
    });
}

</script>
