<template>
    <AppLayout title="Dashboard" :breads="breads">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4">general</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                <CardInfo v-for="stat in stats" :stat="stat" />
            </div>
            <h1 class="block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4">Finanzas: {{ MONHT }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                <CardInfo v-for="finance in finances" :stat="finance" />
            </div>
            <h1 class="block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4">Servicios</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                <CardInfo v-for="service in services" :stat="service" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';
import CardInfo from '@/Components/CardInfo.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { IconActivity, IconCurrencyDollar, IconCurrencyDollarOff, IconGenderFemale, IconGenderMale, IconGift, IconMoneybag, IconRun, IconUser } from '@tabler/icons-vue';

const props = defineProps({
    incomes_month: {
        type: Number,
        required: true,
    },
    expenditures_month: {
        type: Number,
        required: true,
    },
    customers_count: {
        type: Number,
        required: true,
    },
    plans: {
        type: Object,
        required: true,
    },
    active_customers: {
        type: Object,
        required: true,
    },
})

const MONHT = Carbon.now().monthName();

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
]

const stats = [
    {
        title: 'Clientes',
        value: props.customers_count.toLocaleString('en-US'),
        icon: IconUser,
    },
    {
        title: 'Clientes activos',
        value: props.plans.reduce((acc, plan) => (acc + plan.total), 0),
        icon: IconRun,
    },
    {
        title: 'Hombres',
        value: props.active_customers.filter(customer => customer.gender == 'M')[0]?.total ?? 0,
        icon: IconGenderMale,
    },
    {
        title: 'Mujeres',
        value: props.active_customers.filter(customer => customer.gender == 'F')[0]?.total ?? 0,
        icon: IconGenderFemale,
    },
]

const finances = [
    {
        title: 'Ingresos',
        value: 'C$ ' + props.incomes_month.total.toLocaleString('en-US'),
        icon: IconMoneybag,
    },
    {
        title: 'Egresos',
        value: 'C$ ' + props.expenditures_month.toLocaleString('en-US'),
        icon: IconCurrencyDollarOff,
    },
    {
        title: 'Descuentos',
        value: 'C$ ' + props.incomes_month.discount,
        icon: IconGift,
    },
    {
        title: 'Ganancias',
        value: 'C$ ' + (props.incomes_month.total - props.expenditures_month).toLocaleString('en-US'),
        icon: IconCurrencyDollar,
    },
]

const services = props.plans.map((plan) => {
    return {
        title: plan.service.name,
        value: plan.total,
        icon: IconActivity,
    }
});

</script>