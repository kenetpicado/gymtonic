<template>
    <AppLayout title="Dashboard" :breads="breads">

        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <InputForm text="Descripción" name="description" v-model="form.description" autocomplete="on" />
                <InputForm text="Cantidad" name="quantity" v-model="form.quantity" type="number" />
                <InputForm text="Monto" name="value" v-model="form.value" type="number" />
                <InputForm text="Fecha" name="created_at" v-model="form.created_at" type="date" />

                <div class="text-lg font-medium text-gray-900 mb-2">
                    Total: C$ {{ (form.quantity * form.value).toLocaleString('en-US') }}
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
            <template #filters>
                <div class="grid grid-cols-4 mb-1 gap-4">
                    <SelectForm text="Tipo" v-model="queryParams.type">
                        <option v-for="(type, index) in types" :value="index">{{ type }}</option>
                    </SelectForm>
                </div>
            </template>

            <template #topbar>
                <h2 class="text-2xl font-extrabold text-gray-600">
                    {{ types[type] }}: {{ concept.name }}
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
                <tr v-for="(r, index) in records.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="r.created_at" />
                    </td>
                    <td>
                        {{ r.description }}
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ (r.value).toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="r.quantity > 1">
                            Cant. {{ r.quantity }}
                        </div>
                    </td>
                    <td>
                        <span :class="type == 'income' ? 'badge-success' : 'badge-danger'">
                            C$ {{ (r.value * r.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                    <td>
                        <div class="flex gap-4">
                            <span tooltip="Editar" role="button" @click="edit(r)">
                                <IconPencil />
                            </span>

                            <span tooltip="Eliminar" role="button" @click="confirmDestroy(r.id)">
                                <IconTrash />
                            </span>
                        </div>
                    </td>
                </tr>
                <tr v-if="records.data.length == 0">
                    <td colspan="5" class="text-center">
                        No hay datos para mostrar
                    </td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="records.links"></ThePaginator>
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
import {reactive, ref, watch} from 'vue';
import { Carbon } from '@/Classes/Carbon.js';
import SelectForm from "@/Components/Form/SelectForm.vue";

const props = defineProps({
    concept: {
        type: Object, required: true
    },
    records: {
        type: Object, required: true
    },
    type: {
        type: String, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const types = {
    incomes: "Ingresos",
    expenditures: "Egresos"
}

const searchParams = new URLSearchParams(window.location.search);

const queryParams = reactive({
    type: searchParams.get('type') ?? props.type
})

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Conceptos', route: 'dashboard.concepts.index' },
    { name: props.concept.name, route: 'dashboard.concepts.show', params: [props.concept.id] },
]

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    description: '',
    created_at: Carbon.today(),
    model_id: props.concept.id,
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
        router.delete(route(`dashboard.${queryParams.type}.destroy`, id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Registro eliminado correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar este registro?')
}

function save() {
    if (isNew.value) {
        form.post(route(`dashboard.${queryParams.type}.store`), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Registro creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route(`dashboard.${queryParams.type}.update`, form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Registro actualizado correctamente!')
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


watch(() => queryParams, () => {
    let params = { ...route().params, ...queryParams };

    for (const key in params) {
        if (!params[key] || params.concept ) delete params[key];
    }

    router.get(route('dashboard.concepts.show', props.concept.id), params, {
        preserveState: true,
        preserveScroll: true,
        only: ['records', 'type'],
        replace: true,
    });
}, { deep: true });

</script>
