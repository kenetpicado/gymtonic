<template>
    <AppLayout title="Dashboard" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                Nuevo Peso
            </template>
            <template #content>
                <InputForm text="Value" v-model="form.value"></InputForm>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveWeight">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                    Pesos: {{ customer.name }}
                </h2>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>ID</th>
                <th>Fecha</th>
                <th>Peso (lbs)</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(weight, index) in customer.weights" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <DateColumn :date="weight.created_at" />
                    </td>
                    <td>
                        <span class="badge-blue">
                            {{ weight.value }} lbs
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-2">
                            <IconPencil @click="editWeight(weight)" role="button" />

                            <IconTrash @click="removeWeight(weight.id)" role="button" />
                        </div>
                    </td>
                </tr>
                <tr v-if="customer.weights.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TableSection from '@/Components/TableSection.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import { IconPencil, IconTrash } from '@tabler/icons-vue';
import { ref } from 'vue';
import DateColumn from '@/Components/DateColumn.vue';
import { toast } from '@/Use/toast.js';
import { confirmAlert } from "@/Use/alert.js";

const props = defineProps({
    customer: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
    { name: 'Pesos', route: 'dashboard.customers.weights.index', params: [props.customer.id] },
]

const form = useForm({
    id: null,
    value: null,
})

function saveWeight() {
    if (isNew.value) {
        form.post(route('dashboard.customers.weights.store', props.customer.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                toast.success('Weight added successfully');
            },
        });
    } else {
        form.put(route('dashboard.customers.weights.update', [props.customer.id, form.id]), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                resetValues();
                toast.success('Weight updated successfully');
            },
        });
    }
}

async function editWeight(weight) {
    form.id = weight.id;
    form.value = weight.value;
    isNew.value = false;
    openModal.value = true;
}

function removeWeight(id) {
    confirmAlert(() => {
        router.delete(route('dashboard.customers.weights.destroy', [props.customer.id, id]), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Weight deleted successfully');
            },
        });
    }, 'Are you sure you want to delete this weight?');
}

function resetValues() {
    form.reset();
    form.clearErrors();
    openModal.value = false;
    isNew.value = true;
}

</script>