<template>
    <AppLayout title="Usuarios" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar'}}
            </template>
            <template #content>
                    <InputForm text="Nombre" name="name" v-model="form.name"></InputForm>
                    <InputForm text="Correo" name="email" v-model="form.email" type="email"></InputForm>
                    <SelectForm text="Rol" name="role" v-model="form.role">
                    	<option v-for="role in roles">{{ role }}</option>
                    </SelectForm>
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
                <div class="text-2xl font-extrabold text-gray-600 col-span-2">Usuarios</div>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Accciones</th>
            </template>
            <template #body>
                <tr v-for="(user, index) in users" class="hover:bg-gray-50">
                    <td>
                        {{ user.id }}
                    </td>
                    <th>
                        <UserInformation :user="user" />
                    </th>
                    <td>
                        {{ user.email }}
                    </td>
                    <td>
                    	<span class="badge-blue uppercase">{{ user.role }}</span>
                    </td>
                    <td>
                        <IconPencil @click="edit(user)" role="button" />
                    </td>
                </tr>
                <tr v-if="users.length == 0">
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
import UserInformation from '@/Components/UserInformation.vue';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil} from '@tabler/icons-vue';
import { toast } from "@/Use/toast.js";
import SelectForm from '@/Components/Form/SelectForm.vue';

const props = defineProps({
    users: {
        type: Object, required: true
    },
    roles: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Usuarios', route: 'dashboard.users.index' },
]

const form = useForm({
    id: null,
    name: '',
    email: '',
    role: props.roles[props.roles.length - 1],
})

function edit(user) {
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.role = user.role;
    isNew.value = false;
    openModal.value = true;
}

function save() {
    if (isNew.value) {
        form.post(route('dashboard.users.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Usuario creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.users.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Usuario actualizado correctamente!')
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
