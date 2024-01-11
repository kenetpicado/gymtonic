<template>
    <AppLayout title="Dashboard" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <div class="flex flex-col gap-6">
                    <div>
                        <textarea rows="4"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                            v-model="form.text"></textarea>

                        <p class="text-sm text-red-600 mt-1" v-if="$page.props.errors['text']">
                            {{ $page.props.errors['text'] }}
                        </p>
                    </div>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveNote">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between mb-6 gap-4">
                <div></div>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
                <div class="w-full p-6 bg-white shadow-soft-xl rounded-xl" v-for="(note, index) in notes">
                    <div class="flex flex-col justify-between h-full">
                        <div>
                            <div class="flex justify-between">
                                <div class="mb-2">
                                    {{ Carbon.create(note.created_at).format("d de F, Y") }}
                                </div>
                                <IconCircleCheck v-if="!note.is_done" @click="markAsDone(note)" role="button" />
                                <IconCircleCheckFilled v-else class="text-green-500" role="button"
                                    @click="markAsNotDone(note)" />
                            </div>
                            <p class="mb-4 font-normal text-gray-500 mt-2" role="button" @click="editNote(note)">
                                {{ note.text }}
                            </p>
                        </div>
                        <IconTrash @click="confirmDelete(note.id)" role="button" size="20" class="text-gray-400"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';
import DialogModal from '@/Components/DialogModal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { toast } from "@/Use/toast.js";
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { IconCircleCheck, IconCircleCheckFilled, IconTrash } from '@tabler/icons-vue';
import { confirmAlert } from '@/Use/alert.js';

const props = defineProps({
    notes: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const form = useForm({
    id: null,
    is_done: false,
    text: '',
})

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Notas', route: 'dashboard.notes.index' },
]

function editNote(note) {
    form.id = note.id;
    form.text = note.text;
    isNew.value = false;
    openModal.value = true;
}

function markAsDone(note) {
    form.id = note.id;
    form.text = note.text;
    form.is_done = true;
    updateNote()
}

function markAsNotDone(note) {
    form.id = note.id;
    form.text = note.text;
    form.is_done = false;
    updateNote()
}

function confirmDelete(id) {
    confirmAlert(() => {
        form.delete(route('dashboard.notes.destroy', id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Nota eliminada correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar esta nota?')
}

function saveNote() {
    if (isNew.value) {
        form.post(route('dashboard.notes.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Nota creada correctamente!')
                resetValues()
            },
        });
    } else {
        updateNote()
    }
}

function updateNote() {
    form.put(route('dashboard.notes.update', form.id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Nota actualizada correctamente!')
            resetValues()
        },
    });
}

function resetValues() {
    form.reset();
    isNew.value = true;
    openModal.value = false;
    usePage().props.errors = {};
}

</script>
