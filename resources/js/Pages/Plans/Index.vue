<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import useProfileUrl from '@/Composables/useProfileUrl.js';
import SearchComponent from '@/Components/SearchComponent.vue';
import { reactive, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    plans: {
        type: Object, required: true
    },
    today: {
        type: String, required: true
    },
})

const profileUrl = useProfileUrl();
const checkBox = ref(true);
const openModal = ref(false);

const queryParams = reactive({
    search: '',
    type: 'active'
})

const formExtendPlan = reactive({
    days: '',
    plan_ids: [],
})

const selectedPlans = ref([]);

watch(() => checkBox.value, (value) => {
    queryParams.type = value ? 'active' : 'expired';
    getFilteredPlans();
})

function searchPlans(value) {
    queryParams.search = value;
    getFilteredPlans()
}

function addDays(id) {
    selectedPlans.value = props.plans.data.filter((plan) => plan.selected).map((plan) => plan.id);

    if (selectedPlans.value.length > 0) {
        formExtendPlan.plan_ids = selectedPlans.value;
    } else {
        formExtendPlan.plan_ids = [id];
    }

    console.log(formExtendPlan.plan_ids);

    openModal.value = true;
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

function submitAddDays() {
    router.put(route('dashboard.extend-plan'), formExtendPlan, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
            formExtendPlan.days = '';
            formExtendPlan.plan_ids = [];
            selectedPlans.value = [];
            openModal.value = false;
        },
    });
}

function cancelAddDays() {
    formExtendPlan.days = '';
    formExtendPlan.plan_ids = [];
    openModal.value = false;
}

function editPlan(id) {
    router.visit(route('dashboard.plans.edit', id));
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
                    <InputForm text="Days" v-model="formExtendPlan.days"></InputForm>
                </template>
                <template #footer>
                    <SecondaryButton @click="cancelAddDays">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton type="button" @click="submitAddDays">
                        Save
                    </PrimaryButton>
                </template>
            </DialogModal>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <Checkbox v-model:checked="checkBox" name="status" />
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </div>
                    <SearchComponent @search="searchPlans"></SearchComponent>
                </div>
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="overflow-hidden rounded-lg m-0">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Period</th>
                                    <th>State</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr v-for="(plan, index) in  plans.data " class="hover:bg-gray-50">
                                    <th>
                                        <Checkbox v-model:checked="plan.selected" name="status" />
                                    </th>
                                    <td>
                                        {{ index + 1 }}
                                    </td>
                                    <td class="flex gap-3 font-normal text-gray-900 items-center">
                                        <div class="h-10 w-10">
                                            <img class="h-full w-full rounded-full object-cover object-center"
                                                :src="profileUrl.get(plan.customer.name)" alt="" />
                                        </div>
                                        <div class="text-sm">
                                            <div class="font-medium text-gray-700">{{ plan.customer.name }}</div>
                                        </div>
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
                                        <span class="badge-blue" @click="addDays(plan.id)" role="button">
                                            {{ plan.end_date_formated }}
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="plan.end_date == today" class="badge-danger">
                                            Last Day
                                        </span>
                                        <span v-else-if="checkBox" class="badge-success">
                                            <span class="dot-green"></span>
                                            Active
                                        </span>
                                        <span v-else class="badge-gray">
                                            <span class="dot-gray"></span>
                                            Expired
                                        </span>
                                    </td>
                                    <td>
                                        <span v-if="checkBox" role="button" class="mr-3"
                                            @click="$inertia.visit(route('dashboard.customers.edit', plan.customer.id))">
                                            <i class="fas fa-edit"></i>
                                        </span>

                                        <span role="button" class="badge-blue" @click="editPlan(plan.id)">
                                            {{ checkBox ? 'Pay $' : 'Renew $' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="plans.data.length == 0">
                                    <td colspan="7" class="text-center">No data to display</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <ThePaginator :links="plans.links"></ThePaginator>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
