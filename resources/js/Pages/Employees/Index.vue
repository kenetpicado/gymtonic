<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import useNotify from '@/Use/notify.js';
import UserInformation from '@/Components/UserInformation.vue';
import TableSection from '@/Components/TableSection.vue';

const props = defineProps({
    employees: {
        type: Object, required: true
    }
})

const openModal = ref(false)
const isNew = ref(true);
const notify = useNotify();

const form = useForm({
    id: null,
    name: '',
    phone: '',
    schedule: '',
})

function saveEmployee() {
    if (isNew.value) {
        form.post(route('dashboard.employees.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Employee created successfully')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.employees.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                notify.success('Employee updated successfully')
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

function editEmployee(employee) {
    form.id = employee.id;
    form.name = employee.name;
    form.phone = employee.phone;
    form.schedule = employee.schedule;
    isNew.value = false;
    openModal.value = true;
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                Employees
            </h2>
            <div>
                <PrimaryButton type="button" @click="openModal = true">
                    New
                </PrimaryButton>
            </div>
        </template>

        <DialogModal :show="openModal">
            <template #title>
                New Employee
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
                    Cancel
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveEmployee">
                    Save
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #header>
                <th>ID</th>
                <th>Name</th>
                <th>Schedule</th>
                <th>Actions</th>
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
                        <i class="fas fa-eye mr-3" role="button"
                            @click="$inertia.visit(route('dashboard.employees.show', employee.id))"></i>

                        <i class="fas fa-edit mr-3" role="button" @click="editEmployee(employee)"></i>
                    </td>
                </tr>
                <tr v-if="employees.length == 0">
                    <td colspan="4" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>
    </AppLayout>
</template>
