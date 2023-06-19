<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Payments: {{concept.name}}
            </h2>
            <div>
                <!-- <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.expenditures.create'))">
                    New
                </PrimaryButton> -->
            </div>
        </template>

        <TableSection>
            <template #topbar>
                <!-- <SearchComponent :url="route('dashboard.expenditures.index')" :only="['expenditures']"></SearchComponent> -->
            </template>

            <template #header>
                <th>Date</th>
                <th>Concept</th>
                <th>Amount</th>
                <th>Total</th>
            </template>

            <template #body>
                <tr v-for="(expenditure, index) in expenditures.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="expenditure.created_at" />
                    </td>
                    <td>
                        <ConceptInfo :type="expenditure" />
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ (expenditure.amount).toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="expenditure.quantity > 1">
                            Qty: {{ expenditure.quantity }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-danger">
                            C$ {{ (expenditure.amount * expenditure.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                </tr>
                <tr v-if="expenditures.data.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="expenditures.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil, IconEye, IconArrowUp, IconArrowDown } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';
import { toast } from "@/Use/toast.js";
import ConceptInformation from '@/Components/ConceptInformation.vue';
import { usePage } from '@inertiajs/vue3';
import ConceptInfo from '@/Components/ConceptInfo.vue';
import DateColumn from '@/Components/DateColumn.vue';
import ThePaginator from '@/Components/ThePaginator.vue';

const props = defineProps({
    concept: {
        type: Object, required: true
    },
    expenditures: {
        type: Object, required: true
    }
})

// const openModal = ref(false)
// const isNew = ref(true);

// const form = useForm({
//     id: null,
//     name: '',
//     image: '',
// })

// function editConcept(concept) {
//     form.id = concept.id;
//     form.name = concept.name;
//     form.image = concept.image;
//     isNew.value = false;
//     openModal.value = true;
// }

// function saveConcept() {
//     if (isNew.value) {
//         form.post(route('dashboard.concepts.store'), {
//             preserveScroll: true,
//             preserveState: true,
//             onSuccess: () => {
//                 toast.success('Concept created successfully')
//                 resetValues()
//             },
//         });
//     } else {
//         form.put(route('dashboard.concepts.update', form.id), {
//             preserveScroll: true,
//             preserveState: true,
//             onSuccess: () => {
//                 toast.success('Concept updated successfully')
//                 resetValues()
//             },
//         });
//     }
// }

// function resetValues() {
//     form.reset();
//     isNew.value = true;
//     openModal.value = false;
//     usePage().props.errors = {};
// }

</script>
