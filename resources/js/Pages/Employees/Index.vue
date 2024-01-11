<template>
    <AppLayout title="Dashboard" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <div class="grid gap-6">
                    <InputForm text="Name" v-model="form.name"></InputForm>
                    <InputForm text="Phone" v-model="form.phone" type="number"></InputForm>
                    <InputForm text="Schedule" v-model="form.schedule"></InputForm>
                </div>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveEmployee">
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
                <th>ID</th>
                <th>Nombre</th>
                <th>Horario</th>
                <th>Acciones</th>
            </template>
            <template #body>
                <tr v-for="(employee, index) in employees" class="hover:bg-gray-50">
                    <td>
                        {{ employee.id }}
                    </td>
                    <th>
                        <UserInformation :user="employee" />
                    </th>
                    <td>
                        {{ employee.schedule }}
                    </td>
                    <td>
                        <div class="flex gap-3">
                            <Link :href="route('dashboard.employees.show', employee.id)" tooltip="Pagos">
                            <IconCurrencyDollar />
                            </Link>

                            <span role="button" tooltip="Editar" @click="editEmployee(employee)">
                                <IconPencil />
                            </span>
                        </div>
                    </td>
                </tr>
                <tr v-if="employees.length == 0">
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
import { IconPencil, IconEye, IconCurrencyDollar } from '@tabler/icons-vue';
import { Link } from '@inertiajs/vue3';
import { toast } from "@/Use/toast.js";

const props = defineProps({
    employees: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Personal', route: 'dashboard.employees.index' },
]

const form = useForm({
    id: null,
    name: '',
    phone: '',
    schedule: '',
})

function editEmployee(employee) {
    form.id = employee.id;
    form.name = employee.name;
    form.phone = employee.phone;
    form.schedule = employee.schedule;
    isNew.value = false;
    openModal.value = true;
}

function saveEmployee() {
    if (isNew.value) {
        form.post(route('dashboard.employees.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Empleado creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.employees.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Empleado actualizado correctamente!')
                resetValues()
            },
        });
    }
}

function resetValues() {
    form.reset();
    form.clearErrors();
    isNew.value = true;
    openModal.value = false;
}

</script>
