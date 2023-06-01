<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight p-1">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-6 mb-6">
                    <CardInfo title="Customers" :value="customers_total" />
                    <CardInfo title="Plans" :value="plans_count" />
                    <CardInfo :title="`Incomes ${month}`" :value="`C$ ${incomes_month.total ?? 0}`" />
                    <CardInfo :title="`Expenditures ${month}`" :value="`C$ ${expenditures_month ?? 0}`" />
                    <CardInfo :title="`Revenue ${month}`"
                        :value="`C$ ${incomes_month.total ?? 0 - expenditures_month ?? 0}`" />
                    <CardInfo :title="`Discount ${month}`" :value="`C$ ${incomes_month.discount ?? 0}`" />
                    <!-- <pre>{{ customers }}</pre> -->
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white shadow-lg p-4 rounded-lg">
                        <canvas id="genderChart"></canvas>
                    </div>
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

const props = defineProps({
    plans_count: {
        type: Number,
        required: true,
    },
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
})

const month = monthName();

const customers_total = props.customers.reduce((acc, customer) => {
    return acc + customer.total;
}, 0);

function monthName() {
    const names = [
        "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
    ];

    const month = new Date().getMonth();
    return names[month];
}

onMounted(() => {
    const ctx = document.getElementById('genderChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: props.customers.map((customer) => customer.gender),
            datasets: [{
                label: '# of Votes',
                data: props.customers.map((customer) => customer.total),
                backgroundColor: '#c7d2fe',
                borderColor: '#4f46e5',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
        }
    });
})

</script>