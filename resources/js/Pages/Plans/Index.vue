<template>
    <AppLayout title="Dashboard" :breads="breads">
        <DialogModal :show="openModal">
            <template #title>
                Agregar dias
            </template>
            <template #content>
                <InputForm text="Dias" name="days" v-model="days" type="number"></InputForm>
                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 mt-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>Plan ID</th>
                            <th>Cliente</th>
                            <th>Finaliza</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                        <tr v-for="plan in selectedPlans">
                            <td>{{ plan.id }}</td>
                            <td>{{ plan.customer }}</td>
                            <td>{{ Carbon.create(plan.end_date).format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="submitAddDays">
                    Guardar
                </PrimaryButton>
            </template>
        </DialogModal>

        <TableSection>
            <template #topbar>
                <div class="flex items-center gap-4">
                    <SearchComponent @search="searchPlans" />
                </div>

                <div class="flex gap-2 items-center">
                    <div v-show="atLeastOnePlanSelected">
                        <PrimaryButton type="button" @click="openModalToAddDays()">
                            Agregar dias
                        </PrimaryButton>
                    </div>
                    <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.customers.create'))">
                        Nuevo
                    </PrimaryButton>
                </div>
            </template>

            <template #header>
                <th>Cliente</th>
                <th>Servicio</th>
                <th>Expira</th>
                <th>Estado</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="(plan, index) in  plans.data " class="hover:bg-gray-50">
                    <td>
                        <div class="flex items-center gap-4">
                            <Checkbox v-model:checked="plan.selected" name="status" />
                            <UserInformation :user="{ name: plan.customer_name }" />
                        </div>
                    </td>
                    <td>
                        {{ plan.service_name }} ({{ plan.period }} dias)
                    </td>
                    <td>
                        <span class="badge-blue" :tooltip="Carbon.create(plan.end_date + ' 23:59:00').diffForHumans()">
                            {{ Carbon.create(plan.end_date).format("d de F") }}
                        </span>
                    </td>
                    <td>
                        <div class="flex items-center">
                            <span v-if="plan.end_date == TODAY" class="badge-danger">
                                ULTIMO DIA!
                            </span>
                            <span v-else class="badge-success">
                                Activo
                            </span>
                        </div>
                    </td>
                    <td>
                        <Link :href="route('dashboard.customers.plans.create', plan.customer_id)" class="badge-blue">
                            Pagar
                        </Link>
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

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import { reactive, ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Carbon } from '@/Classes/Carbon.js';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import useNotify from '@/Use/notify.js';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    plans: {
        type: Object, required: true
    },
})

const openModal = ref(false);
const days = ref(null);
const notify = useNotify();
const selectedPlans = ref([]);
const TODAY = Carbon.today('Y-m-d');

const queryParams = reactive({
    search: '',
    type: 'active'
})

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Planes', route: 'dashboard.plans.index' },
]

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

function initSelectedPlans() {
    selectedPlans.value = props.plans.data
        .filter((plan) => plan.selected)
        .map(function (plan) {
            return {
                id: plan.id,
                customer: plan.customer_name,
                end_date: plan.end_date
            }
        })
}

const atLeastOnePlanSelected = computed(() => {
    return props.plans.data.some((plan) => plan.selected);
})

function openModalToAddDays() {
    initSelectedPlans()

    if (selectedPlans.value.length == 0) {
        notify.error('Select at least one plan');
        return;
    }

    openModal.value = true;
}

watch(() => days.value, (value) => {
    initSelectedPlans()

    if (!value) {
        return;
    };

    selectedPlans.value.forEach((plan) => {
        plan.end_date = Carbon.create(plan.end_date).addDays(parseInt(value)).format('Y-m-d');
    })
})

function submitAddDays() {
    if (!days.value || days.value == 0 || days.value < 1) {
        notify.error('Days must be greater than 0');
        return;
    };

    router.put(route('dashboard.plans.extend'), selectedPlans.value, {
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

</script>
