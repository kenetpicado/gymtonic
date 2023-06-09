<template>
    <AppLayout title="Dashboard" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <div class="flex flex-col gap-6">
                    <InputForm text="Name" v-model="form.name" />

                    <div class="grid grid-cols-2 gap-4">
                        <Checkbox v-model:checked="form.has_income" text="Ingresos" />
                        <Checkbox v-model:checked="form.has_expenditure" text="Egresos" />
                        <Checkbox v-model:checked="form.notify_income" text="Notificaciones" />
                        <Checkbox v-model:checked="form.notify_expenditure" text="Notificaciones" />
                    </div>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveConcept">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <div></div>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>#</th>
                <th>Nombre</th>
                <th>Egresos</th>
                <th>Ingresos</th>
                <th>Acciones</th>
            </template>
            <template #body>
                <tr v-for="(concept, index) in concepts.data" class="hover:bg-gray-50">
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <ConceptInformation :concept="concept" />
                    </td>
                    <td>
                        <Link v-if="concept.has_expenditure"
                            :href="route('dashboard.concepts.expenditures.index', concept.id)" tooltip="Egresos" class="text-pink-600">
                        <IconCurrencyDollarOff />
                        </Link>
                    </td>
                    <td>
                        <Link v-if="concept.has_income"
                            :href="route('dashboard.concepts.incomes.index', concept.id)" tooltip="Ingresos" class="text-green-500">
                        <IconMoneybag />
                        </Link>
                    </td>
                    <td>
                        <IconPencil @click="editConcept(concept)" role="button" />
                    </td>
                </tr>
                <tr v-if="concepts.data.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
            <template #paginator>
                <ThePaginator :links="concepts.links"></ThePaginator>
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, watch } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil, IconMoneybag, IconCurrencyDollarOff } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';
import { toast } from "@/Use/toast.js";
import ConceptInformation from '@/Components/ConceptInformation.vue';
import { usePage } from '@inertiajs/vue3';
import ThePaginator from '@/Components/ThePaginator.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    concepts: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const form = useForm({
    id: null,
    name: '',
    has_income: false,
    notify_income: false,
    has_expenditure: true,
    notify_expenditure: false,
})

watch(() => [form.notify_income, form.notify_expenditure], ([income, expenditure]) => {
    if (income)
        form.has_income = true

    if (expenditure)
        form.has_expenditure = true
})

watch(() => [form.has_income, form.has_expenditure], ([income, expenditure]) => {
    if (!income)
        form.notify_income = false

    if (!expenditure)
        form.notify_expenditure = false
})

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Conceptos', route: 'dashboard.concepts.index' },
]

function editConcept(concept) {
    form.id = concept.id;
    form.name = concept.name;
    form.has_income = Boolean(concept.has_income),
    form.notify_income = Boolean(concept.notify_income),
    form.has_expenditure = Boolean(concept.has_expenditure),
    form.notify_expenditure = Boolean(concept.notify_expenditure),
    isNew.value = false;
    openModal.value = true;
}

function saveConcept() {
    if (isNew.value) {
        form.post(route('dashboard.concepts.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Concepto creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.concepts.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Concepto actualizado correctamente!')
                resetValues()
            },
        });
    }
}

function resetValues() {
    form.reset();
    isNew.value = true;
    openModal.value = false;
    usePage().props.errors = {};
}

</script>
