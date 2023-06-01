<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import { reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Datep } from '@/Classes/Datep.js';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import useNotify from '@/Use/notify.js';

const props = defineProps({
    plans: {
        type: Object, required: true
    },
    today: {
        type: String, required: true
    },
})

const checkBox = ref(true);
const openModal = ref(false);
const days = ref(null);
const notify = useNotify();
const selectedPlans = ref([]);

const queryParams = reactive({
    search: '',
    type: 'active'
})

watch(() => checkBox.value, (value) => {
    queryParams.type = value ? 'active' : 'expired';
    getFilteredPlans();
})

function searchPlans(value) {
    queryParams.search = value;
    getFilteredPlans()
}

function getFilteredPlans() {
    if (queryParams.search === '') {
        delete queryParams.search;
    }

    router.get(route('dashboard.plans.index'), queryParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['plans'],
        replace: true,
    });
}

function firstSelectedPlans() {
    selectedPlans.value = props.plans.data
        .filter((plan) => plan.selected)
        .map(function (plan) {
            return {
                id: plan.id,
                customer: plan.customer.name,
                end_date: plan.end_date
            }
        })
}

function openModalToAddDays() {
    firstSelectedPlans()

    if (selectedPlans.value.length == 0) {
        notify.error('Select at least one plan');
        return;
    }

    openModal.value = true;
}

watch(() => days.value, (value) => {
    if (!value) {
        firstSelectedPlans()
        return;
    };

    selectedPlans.value.forEach((plan) => {
        const date = new Datep(plan.end_date);
        plan.end_date = date.addPeriod(parseInt(value) + 1).format('Y-m-d');
    })
})

function submitAddDays() {
    if (!days.value || days.value == 0 || days.value < 1) {
        notify.error('Days must be greater than 0');
        return;
    };

    router.put(route('dashboard.extend-plan'), selectedPlans.value, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            resetValues();
            notify.success('Days added successfully');
        },
    });
}

function resetValues() {
    days.value = null;
    selectedPlans.value = [];
    openModal.value = false;
}

function isPaymentToday(planDate) {
    return props.today == new Datep(planDate).addDays(2).format('Y-m-d');
}

</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight items-center">
                {{ checkBox ? 'Active Plans' : 'Expired Plans' }}
            </h2>
            <div>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.customers.create'))">
                    New
                </PrimaryButton>
            </div>

            <DialogModal :show="openModal">
                <template #title>
                    Extend Plan
                </template>
                <template #content>
                    <InputForm text="Days" v-model="days" type="number"></InputForm>
                    <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>Customer</th>
                                <th>End date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                            <tr v-for="plan in selectedPlans">
                                <td>{{ plan.customer }}</td>
                                <td>{{ plan.end_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <template #footer>
                    <SecondaryButton @click="resetValues">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton type="button" @click="submitAddDays">
                        Save
                    </PrimaryButton>
                </template>
            </DialogModal>
        </template>

        <TableSection>
            <template #topbar>
                <div>
                    <Checkbox v-model:checked="checkBox" name="status" />
                    <span class="ml-2 text-sm text-gray-600">Active</span>
                </div>
                <SearchComponent @search="searchPlans"></SearchComponent>
            </template>

            <template #header>
                <th></th>
                <th>ID</th>
                <th>Customer</th>
                <th>Service</th>
                <th>Period</th>
                <th>State</th>
                <th>Actions</th>
            </template>

            <template #body>
                <tr v-for="(plan, index) in  plans.data " class="hover:bg-gray-50">
                    <th>
                        <Checkbox v-model:checked="plan.selected" name="status" />
                    </th>
                    <td>
                        {{ index + 1 }}
                    </td>
                    <td>
                        <UserInformation :user="plan.customer" />
                    </td>
                    <td>
                        {{ plan.service.name }}
                        <div class="text-sm mt-1">
                            ({{ plan.period }} days)
                        </div>
                    </td>
                    <td>
                        <span class="badge-gray">
                            {{ plan.start_date_formated }}
                        </span>
                        <span class="badge-blue" @click="openModalToAddDays(plan)" role="button">
                            {{ plan.end_date_formated }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <span v-if="plan.end_date == today" class="badge-danger">
                                Last Day
                            </span>
                            <span v-else-if="checkBox" class="badge-success">
                                <span class="dot-green"></span>
                                Active
                            </span>
                            <span v-else-if="isPaymentToday(plan.end_date)" class="badge-pink">
                                Payment today
                            </span>
                            <span v-else class="badge-gray">
                                <span class="dot-gray"></span>
                                Expired
                            </span>
                        </div>
                    </td>
                    <td>
                        <span role="button" class="badge-blue"
                            @click="$inertia.visit(route('dashboard.plans.edit', plan.id))">
                            {{ checkBox ? 'Pay $' : 'Renew $' }}
                        </span>
                    </td>
                </tr>
                <tr v-if="plans.data.length == 0">
                    <td colspan="7" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="plans.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>
