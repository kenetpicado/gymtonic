<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Concepts
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Concept
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Name" v-model="form.name"></InputForm>
                    <InputForm text="Image" v-model="form.image" type="url"></InputForm>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancel
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveConcept">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #header>
                <th>#</th>
                <th>Name</th>
                <th>Actions</th>
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
                        <div class="flex gap-2">
                            <Link :href="route('dashboard.concepts.show', concept.id)">
                            <IconEye />
                            </Link>

                            <IconPencil @click="editConcept(concept)" role="button" />
                        </div>
                    </td>
                </tr>
                <tr v-if="concepts.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
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
import { IconPencil, IconEye } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';
import { toast } from "@/Use/toast.js";
import ConceptInformation from '@/Components/ConceptInformation.vue';
import { usePage } from '@inertiajs/vue3';

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
    image: '',
})

function editConcept(concept) {
    form.id = concept.id;
    form.name = concept.name;
    form.image = concept.image;
    isNew.value = false;
    openModal.value = true;
}

function saveConcept() {
    if (isNew.value) {
        form.post(route('dashboard.concepts.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Concept created successfully')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.concepts.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Concept updated successfully')
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
