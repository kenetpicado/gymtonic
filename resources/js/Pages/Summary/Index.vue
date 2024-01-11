<template>
    <AppLayout title="Resumen" :breads="breads">

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
                        <option v-for="y in years" :value="y">{{ y }}</option>
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
                <tr v-if="mapedResults.length == 0">
                    <td colspan="7" class="text-center">
                        No hay datos para mostrar
                    </td>
                </tr>
                <template v-for="month in mapedResults">
                    <tr class="hover:bg-gray-50">
                        <td>
                            {{ month.id }}
                        </td>
                        <td>
                            {{ month.name }}
                        </td>
                        <td>
                            {{ month.clients }}
                        </td>
                        <td>
                            {{ month.plans }}
                        </td>
                        <td>
                            <span class="badge-success">
                                {{ month.income }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-danger">
                                {{ month.expenditure }}
                            </span>
                        </td>
                        <td>
                            <span :class="month.revenue_class">
                                {{ month.renevue }}
                            </span>
                        </td>
                    </tr>
                </template>
                <tr class="bg-gray-50" v-if="mapedResults.length > 0">
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
    { name: 'Inicio', route: 'dashboard.index' },
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

const mapedResults = computed(() => {
    const results = [];

    for (const month of monthList) {
        const income = props.incomes.find(income => income.month === month.id)?.total ?? 0
        const expenditure = props.expenditures.find(expenditure => expenditure.month === month.id)?.total ?? 0

        if (income === 0 && expenditure === 0) {
            continue;
        }

        results.push({
            id: month.id,
            name: month.name,
            clients: props.clients.find(client => client.month === month.id)?.total ?? 0,
            plans: props.plans.find(plan => plan.month === month.id)?.total ?? 0,
            income: 'C$ ' + income.toLocaleString(),
            expenditure: 'C$ ' + expenditure.toLocaleString(),
            renevue: 'C$ ' + (income - expenditure).toLocaleString(),
            revenue_class: income - expenditure > 0 ? 'badge-success' : 'badge-danger',
        })
    }

    return results;
})

const years = Array.from({ length: 4 }, (_, i) => new Date().getFullYear() - i).filter(year => year !== new Date().getFullYear())

</script>
