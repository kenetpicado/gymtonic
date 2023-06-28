<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Payments: {{ concept.name }}
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Payment
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Concept" v-model="form.concept" />
                    <InputForm text="Description (optional)" v-model="form.description" />
                    <InputForm text="Quantity" v-model="form.quantity" type="number" />
                    <InputForm text="Amount" v-model="form.amount" />

                    <div class="col-span-4 text-lg font-medium text-gray-900 mb-2">
                        <h3>
                            Total: C$ {{ total }}
                        </h3>
                    </div>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancel
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveExpenditure">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>

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
import ConceptInfo from '@/Components/ConceptInfo.vue';
import DateColumn from '@/Components/DateColumn.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TableSection from '@/Components/TableSection.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toast } from "@/Use/toast.js";
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    concept: {
        type: Object, required: true
    },
    expenditures: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const form = useForm({
    quantity: 1,
    amount: props.expenditures.data.length > 0 ? props.expenditures.data[0].amount : 0,
    concept: '',
    expenditureable_id: props.concept.id,
    expenditureable_type: 'App\\Models\\Concept'
})

const total = computed(() => {
    return (form.quantity * form.amount).toLocaleString('en-US')
})

function saveExpenditure() {
    if (isNew.value) {
        form.post(route('dashboard.concepts.expenditures.store', props.concept.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Payment created successfully')
                resetValues()
            },
        });
    } else {
        // form.put(route('dashboard.concepts.expenditures.update', form.id), {
        //     preserveScroll: true,
        //     preserveState: true,
        //     onSuccess: () => {
        //         toast.success('Payment updated successfully')
        //         resetValues()
        //     },
        // });
    }
}

function resetValues() {
    form.reset();
    isNew.value = true;
    openModal.value = false;
}

</script>
