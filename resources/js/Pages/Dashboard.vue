<template>
    <AppLayout title="Dashboard" :breads="breads">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-5 gap-6 mb-6">
                <CardInfo v-for="stat in stats" :stat="stat" />
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white shadow-lg py-2 px-4 rounded-xl">
                    <div class="text-lg mb-4 font-bold tracking-wider">Services</div>
                    <canvas id="serviceChart"></canvas>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CardInfo from '@/Components/CardInfo.vue';
import Chart from 'chart.js/auto'
import { onMounted } from 'vue';
import { Carbon } from '@/Classes/Carbon.js';

const props = defineProps({
    incomes_month: {
        type: Number,
        required: true,
    },
    expenditures_month: {
        type: Number,
        required: true,
    },
    customers: {
        type: Object,
        required: true,
    },
    plans: {
        type: Object,
        required: true,
    }
})

const MONHT = Carbon.now().monthName();

const customers_total = props.customers.reduce((acc, customer) => {
    return acc + customer.total;
}, 0);

const plans_total = props.plans.reduce((acc, plan) => {
    return acc + plan.total;
}, 0);

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
]

const serviceList = [
    "Pesas",
    "Zumba",
    "Zumba + Pesas"
]

const stats = [
    {
        title: 'Clientes',
        value: customers_total,
    },
    {
        title: 'Hombres',
        value: props.customers.filter(customer => customer.gender == 'M')[0]?.total ?? 0
    },
    {
        title: 'Mujeres',
        value: props.customers.filter(customer => customer.gender == 'F')[0]?.total ?? 0
    },
    {
        title: 'Planes',
        value: plans_total,
    },
    {
        title: 'Ingresos ' + MONHT,
        value: 'C$ ' + props.incomes_month.total,
    },
    {
        title: 'Gastos ' + MONHT,
        value: 'C$ ' + props.expenditures_month,
    },
    {
        title: 'Ganancias ' + MONHT,
        value: 'C$ ' + (props.incomes_month.total - props.expenditures_month),
    },
    {
        title: 'Descuentos ' + MONHT,
        value: 'C$ ' + props.incomes_month.discount,
    },
]

const options = {
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
        }
    },
}

onMounted(() => {
    new Chart(document.getElementById('genderChart'), {
        type: 'bar',
        data: {
            labels: props.customers.map((customer) => customer.gender),
            datasets: [{
                data: props.customers.map((customer) => customer.total),
                backgroundColor: '#c7d2fe',
            }]
        },
        options: options
    });

    new Chart(document.getElementById('serviceChart'), {
        type: 'bar',
        data: {
            labels: props.plans.map((plan) => serviceList[plan.service_id - 1]),
            datasets: [{
                data: props.plans.map((plan) => plan.total),
                backgroundColor: '#c7d2fe',
            }]
        },
        options: options
    });
})

</script>