<template>
    <AppLayout title="Dashboard" :breads="breads">
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
                <th>Estrellas</th>
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
                        <span v-if="customer.stars" class="flex text-amber-500 gap-1" @click="addStarsInput(customer.id)"
                            role="button">
                            <IconStarFilled size="16" />
                            <span>{{ customer.stars }}</span>
                        </span>
                        <span v-else role="button" @click="addStarsInput(customer.id)">
                            <IconStar size="16" />
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
                        <div class="flex gap-4">
                            <Link :href="route('dashboard.customers.plans.create', customer.id)" class="badge-blue">
                            Pagar
                            </Link>

                            <Link :href="route('dashboard.customers.weights.index', customer.id)" tooltip="Pesos">
                            <IconWeight />
                            </Link>

                            <Link :href="route('dashboard.customers.edit', customer.id)" tooltip="Editar">
                            <IconPencil />
                            </Link>

                            <Link :href="route('dashboard.customers.show', customer.id)" tooltip="Historial">
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
import UserInformation from '@/Components/UserInformation.vue';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil, IconHistory, IconWeight, IconStarFilled, IconStar } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';
import { addStarsInput } from "@/Use/alert.js"

const props = defineProps({
    customers: {
        type: Object, required: true
    }
})

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
]

</script>
