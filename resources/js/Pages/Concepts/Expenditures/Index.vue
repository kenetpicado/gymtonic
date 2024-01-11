<template>
    <AppLayout title="Dashboard" :breads="breads">

        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <InputForm text="Descripcion" name="description" v-model="form.description" autocomplete="on" />
                <InputForm text="Cantidad" name="quantity" v-model="form.quantity" type="number" />
                <InputForm text="Monto" name="value" v-model="form.value" type="number" />
                <InputForm text="Fecha" name="created_at" v-model="form.created_at" type="date" />

                <div class="text-lg font-medium text-gray-900 mb-2">
                    Total: C$ {{ total }}
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="save">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <h2 class="text-2xl font-extrabold text-gray-600">
                    Egresos: {{ concept.name }}
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
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(expenditure, index) in expenditures.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="expenditure.created_at" />
                    </td>
                    <td>
                        {{ expenditure.description }}
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
                    <td>
                        <div class="flex gap-4">
                            <span tooltip="Editar" role="button" @click="edit(expenditure)">
                                <IconPencil />
                            </span>

                            <span tooltip="Eliminar" role="button" @click="confirmDestroy(expenditure.id)">
                                <IconTrash />
                            </span>
                        </div>
                    </td>
                </tr>
                <tr v-if="expenditures.data.length == 0">
                    <td colspan="5" class="text-center">
                        No hay datos para mostrar
                    </td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="expenditures.links"></ThePaginator>
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
    expenditures: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Conceptos', route: 'dashboard.concepts.index' },
    { name: props.concept.name, route: 'dashboard.concepts.expenditures.index', params: [props.concept.id] },
]

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    description: '',
    created_at: Carbon.today(),
    expenditureable_id: props.concept.id,
    expenditureable_type: 'App\\Models\\Concept'
})

const total = computed(() => {
    return (form.quantity * form.value).toLocaleString('en-US')
})

function edit(expenditure) {
    form.id = expenditure.id;
    form.quantity = expenditure.quantity;
    form.value = expenditure.value;
    form.description = expenditure.description;
    isNew.value = false;
    openModal.value = true;
}

function confirmDestroy(id) {
    useNotify().confirm(() => {
        router.delete(route('dashboard.expenditures.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Pago eliminado correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar este pago?')
}

function save() {
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
