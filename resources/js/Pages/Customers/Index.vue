<template>
    <AppLayout title="Dashboard">
        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.customers.index')" :only="['customers']" />

                <Link :href="route('dashboard.customers.create')">
                <PrimaryButton type="button">
                    Nuevo
                </PrimaryButton>
                </Link>
            </template>

            <template #header>
                <th>ID</th>
                <th>Nombre</th>
                <th>Genero</th>
                <th>Estado</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(customer, index) in customers.data" class="hover:bg-gray-50">
                    <td>
                        {{ customer.id }}
                    </td>
                    <th>
                        <UserInformation :user="customer" />
                    </th>
                    <td>
                        <span :class="[customer.gender == 'F' ? 'badge-pink' : 'badge-blue']">
                            {{ customer.gender }}
                        </span>
                    </td>
                    <td>
                        <span v-if="customer.active_plans > 0" class="badge-success">
                            Active
                        </span>
                        <span v-else class="badge-gray">
                            Inactive
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <Link :href="route('dashboard.customers.weights.index', customer.id)">
                            <IconWeight />
                            </Link>

                            <Link :href="route('dashboard.customers.edit', customer.id)">
                            <IconPencil />
                            </Link>

                            <Link :href="route('dashboard.customers.history', customer.id)" tooltip="History">
                            <IconHistory />
                            </Link>
                        </div>
                    </td>
                </tr>
                <tr v-if="customers.data.length == 0">
                    <td colspan="6" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="customers.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineProps } from 'vue';
import UserInformation from '@/Components/UserInformation.vue';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil, IconEye, IconHistory, IconWeight } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    customers: {
        type: Object, required: true
    }
})

</script>
