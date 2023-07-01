<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Empleados
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    Nuevo
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                Nuevo Empleado
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
                        <div class="flex gap-2">
                            <Link :href="route('dashboard.employees.expenditures.index', employee.id)">
                            <IconCurrencyDollar/>
                            </Link>

                            <IconPencil @click="editEmployee(employee)" role="button" />
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
