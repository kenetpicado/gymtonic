<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Customers
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.customers.create'))">
                    New
                </PrimaryButton>
            </div>
        </template>

        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.customers.index')" :only="['customers']" />
            </template>

            <template #header>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>State</th>
                <th>Actions</th>
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
                    <td>{{ customer.age }}</td>
                    <td>
                        <span v-if="customer.active_plans > 0" class="badge-success">
                            <span class="dot-green"></span>
                            Active
                        </span>
                        <span v-else class="badge-gray">
                            Inactive
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <Link :href="route('dashboard.customers.show', customer.id)">
                            <IconEye />
                            </Link>

                            <Link :href="route('dashboard.customers.edit', customer.id)">
                            <IconPencil />
                            </Link>

                            <Link :href="route('dashboard.customers.history', customer.id)">
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
import { IconPencil, IconEye, IconHistory } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    customers: {
        type: Object, required: true
    }
})

</script>
