<template>
    <AppLayout title="Concepto" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                Concepto
            </template>
            <template #content>
                <InputForm text="Nombre" name="name" v-model="form.name" />
                <Checkbox class="mb-4" v-model:checked="form.has_expenditure" text="Egresos" />
                <Checkbox v-model:checked="form.has_income" text="Ingresos" />
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between mb-6 gap-4">
                <h1 class="text-2xl font-extrabold text-gray-600 col-span-2">
                    Conceptos
                </h1>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
                <ConceptCard v-for="(concept, index) in concepts.data" :concept="concept" @onEdit="edit(concept)" />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import ConceptCard from '@/Components/ConceptCard.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toast } from "@/Use/toast.js";
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

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
    has_expenditure: true,
})

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Conceptos', route: 'dashboard.concepts.index' },
]

function edit(concept) {
    form.id = concept.id;
    form.name = concept.name;
    form.has_income = Boolean(concept.has_income),
    form.has_expenditure = Boolean(concept.has_expenditure),
    isNew.value = false;
    openModal.value = true;
}

function save() {
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
