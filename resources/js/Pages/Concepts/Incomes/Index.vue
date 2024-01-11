<template>
    <AppLayout title="Dashboard" :breads="breads">

        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Description" v-model="form.description" autocomplete="on" />
                    <InputForm text="Quantity" v-model="form.quantity" type="number" />
                    <InputForm text="Value" v-model="form.value" type="number" />
                    <InputForm text="Created at" v-model="form.created_at" type="date" />

                    <div class="col-span-4 text-lg font-medium text-gray-900 mb-2">
                        Total: C$ {{ total }}
                    </div>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveIncome">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                    Ingresos: {{ concept.name }}
                </h2>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Total</th>
                <th>Actions</th>
            </template>

            <template #body>
                <tr v-for="(income, index) in incomes.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="income.created_at" />
                    </td>
                    <td>
                        {{ income.description }}
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ (income.value).toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="income.quantity > 1">
                            Cant. {{ income.quantity }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-success">
                            C$ {{ (income.value * income.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-4">
                            <span tooltip="Editar" role="button" @click="edit(income)">
                                <IconPencil />
                            </span>

                            <span tooltip="Eliminar" role="button" @click="confirmDestroy(income.id)">
                                <IconTrash />
                            </span>
                        </div>
                    </td>
                </tr>
                <tr v-if="incomes.data.length == 0">
                    <td colspan="5" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="incomes.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import DateColumn from '@/Components/DateColumn.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TableSection from '@/Components/TableSection.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import useNotify from '@/Use/notify.js';
import { toast } from "@/Use/toast.js";
import { router, useForm } from '@inertiajs/vue3';
import { IconPencil, IconTrash } from '@tabler/icons-vue';
import { computed, ref } from 'vue';
import { Carbon } from '@/Classes/Carbon.js';

const props = defineProps({
    concept: {
        type: Object, required: true
    },
    incomes: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Conceptos', route: 'dashboard.concepts.index' },
    { name: props.concept.name, route: 'dashboard.concepts.incomes.index', params: [props.concept.id] },
]

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    description: '',
    created_at: Carbon.today(),
    incomeable_id: props.concept.id,
    incomeable_type: 'App\\Models\\Concept'
})

const total = computed(() => {
    return (form.quantity * form.value).toLocaleString('en-US')
})

function edit(income) {
    form.id = income.id;
    form.quantity = income.quantity;
    form.value = income.value;
    form.description = income.description;
    isNew.value = false;
    openModal.value = true;
}

function confirmDestroy(id) {
    useNotify().confirm(() => {
        router.delete(route('dashboard.incomes.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Ingreso eliminado correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar este pago?')
}

function saveIncome() {
    if (isNew.value) {
        form.post(route('dashboard.incomes.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Ingreso creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.incomes.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Ingreso actualizado correctamente!')
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
