<template>
    <AppLayout title="Dashboard" :breads="breads">
        <TableSection>
            <template #topbar>
                <div class="flex items-center gap-4">
                    <SearchComponent :url="route('dashboard.plans.expired')" :only="['plans']"/>
                </div>
            </template>

            <template #header>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(plan, index) in  plans.data " class="hover:bg-gray-50">
                    <td>
                        <div class="flex items-center gap-4">
                            <UserInformation :user="{ name: plan.customer_name }" />
                        </div>
                    </td>
                    <td>
                        {{ plan.service_name }} ({{ plan.period }} dias)
                    </td>
                    <td>
                        <span class="badge-danger">
                            Expirado {{ Carbon.create(plan.end_date).diffForHumans() }}
                        </span>
                    </td>
                    <td>
                        <Link :href="route('dashboard.customers.plans.create', plan.customer_id)" class="badge-blue">
                            Renovar plan
                        </Link>
                    </td>
                </tr>
                <tr v-if="plans.data.length == 0">
                    <td colspan="7" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="plans.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import { Carbon } from '@/Classes/Carbon.js';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    plans: {
        type: Object, required: true
    },
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Planes expirados', route: 'dashboard.plans.expired' },
]

</script>
