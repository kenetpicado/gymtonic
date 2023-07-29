<template>
    <AppLayout title="Dashboard" :breads="breads">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4">general</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
                <CardInfo v-for="stat in stats" :stat="stat" />
            </div>
            <h1 class="block text-xs text-gray-500 uppercase tracking-wider font-semibold my-4">Finanzas</h1>
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
import AppLayout from '@/Layouts/AppLayout.vue';
import CardInfo from '@/Components/CardInfo.vue';
import { Carbon } from '@/Classes/Carbon.js';
import { IconUser, IconRun, IconGenderMale, IconGenderFemale, IconCurrencyDollarOff, IconCurrencyDollar, IconGift, IconMoneybag, IconActivity } from '@tabler/icons-vue';

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
        value: customers_total.toLocaleString('en-US'),
        icon: IconUser,
    },
    {
        title: 'Hombres',
        value: props.customers.filter(customer => customer.gender == 'M')[0]?.total ?? 0,
        icon: IconGenderMale,
    },
    {
        title: 'Mujeres',
        value: props.customers.filter(customer => customer.gender == 'F')[0]?.total ?? 0,
        icon: IconGenderFemale,
    },
    {
        title: 'Clientes activos',
        value: plans_total,
        icon: IconRun,
    },

]

const finances = [
    {
        title: 'Ingresos ' + MONHT,
        value: 'C$ ' + props.incomes_month.total.toLocaleString('en-US'),
        icon: IconMoneybag,
    },
    {
        title: 'Egresos ' + MONHT,
        value: 'C$ ' + props.expenditures_month.toLocaleString('en-US'),
        icon: IconCurrencyDollarOff,
    },
    {
        title: 'Descuentos ' + MONHT,
        value: 'C$ ' + props.incomes_month.discount,
        icon: IconGift,
    },
    {
        title: 'Ganancias ' + MONHT,
        value: 'C$ ' + (props.incomes_month.total - props.expenditures_month).toLocaleString('en-US'),
        icon: IconCurrencyDollar,
    },
]

const services = props.plans.map((plan) => {
    return {
        title: serviceList[plan.service_id - 1],
        value: plan.total,
        icon: IconActivity,
    }
});

</script>