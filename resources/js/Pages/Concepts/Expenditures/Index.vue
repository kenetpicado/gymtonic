<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Pagos: {{ concept.name }}
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                Nuevo Pago
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Concept" v-model="form.concept" />
                    <InputForm text="Description (optional)" v-model="form.description" />
                    <InputForm text="Quantity" v-model="form.quantity" type="number" />
                    <InputForm text="Value" v-model="form.value" />

                    <div class="col-span-4 text-lg font-medium text-gray-900 mb-2">
                        <h3>
                            Total: C$ {{ total }}
                        </h3>
                    </div>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveExpenditure">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <!-- <SearchComponent :url="route('dashboard.expenditures.index')" :only="['expenditures']"></SearchComponent> -->
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Monto</th>
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
                            C$ {{ (expenditure.value).toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="expenditure.quantity > 1">
                            Cant. {{ expenditure.quantity }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-danger">
                            C$ {{ (expenditure.value * expenditure.quantity).toLocaleString('en-US') }}
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
    id: null,
    quantity: 1,
    value: props.expenditures.data.length > 0 ? props.expenditures.data[0].value : 0,
    concept: '',
    description: '',
    expenditureable_id: props.concept.id,
    expenditureable_type: 'App\\Models\\Concept'
})

const total = computed(() => {
    return (form.quantity * form.value).toLocaleString('en-US')
})

function saveExpenditure() {
    if (isNew.value) {
        form.post(route('dashboard.expenditures.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Pago creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.expenditures.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Pago actualizado correctamente!')
                resetValues()
            },
        });
    }
}

function resetValues() {
    form.reset();
    isNew.value = true;
    openModal.value = false;
}

</script>
