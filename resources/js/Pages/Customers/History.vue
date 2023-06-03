<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ customer.name }} | Income History
            </h2>
        </template>

        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Concept</th>
                <th>Description</th>
                <th>Date</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in customer.incomes" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <th>
                        {{ income.concept }}
                    </th>
                    <td>
                        {{ income.description }}
                    </td>
                    <td>
                        <div class="badge-blue">
                            {{ income.created_at }}
                        </div>
                    </td>
                </tr>
                <tr v-if="customer.incomes.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';

const props = defineProps({
    customer: {
        type: Object, required: true
    }
})

</script>