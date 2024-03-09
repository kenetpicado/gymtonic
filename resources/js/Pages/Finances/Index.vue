<template>
    <AppLayout :title="types[props.type]" :breads="breads">

        <TableSection>
            <template #topbar>
                <h1 class="text-2xl font-extrabold text-gray-600">
                    {{ types[props.type] }}
                </h1>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.finances.create', {type: props.type}))">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #filters>
                <div class="grid grid-cols-4 mb-1 gap-4">
                    <InputForm text="Buscar" v-model="queryParams.search" type="search" />
                    <InputForm v-model="queryParams.from" text="Desde" type="date" />
                    <InputForm v-model="queryParams.to" text="Hasta" type="date" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-4">
                    <CardInfo v-for="stat in stats" :stat="stat" />
                    <CardInfo
                        v-for="stat in concepts.map(item => ({ title: item.incomeable?.name || item.expenditureable?.name, value: item.total }))"
                        :stat="stat" />
                </div>
            </template>

            <template #header>
                <th>Transaccion</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Total</th>
                <th>Actions</th>
            </template>

            <template #body>
                <tr v-for="(finance, index) in data.data" class="hover:bg-gray-50">
                    <td>
                        #{{ finance.id }}
                    </td>
                    <td>
                        <DateColumn :date="finance.created_at" />
                    </td>
                    <td>
                        <template v-if="finance.incomeable">
                            <ConceptInformation v-if="finance.incomeable_type == 'App\\Models\\Concept'"
                                :concept="finance.incomeable" />

                            <UserInformation v-else :user="finance.incomeable" :type="finance.incomeable_type" />
                        </template>

                        <template v-else-if="finance.expenditureable">
                            <ConceptInformation v-if="finance.expenditureable_type == 'App\\Models\\Concept'"
                                :concept="finance.expenditureable" />

                            <UserInformation v-else :user="finance.expenditureable"
                                :type="finance.expenditureable_type" />
                        </template>
                        <div v-else class="font-normal text-gray-900 ">
                            {{ finance.concept }}
                        </div>
                    </td>
                    <td>
                        {{ finance.description }}
                    </td>
                    <td>
                        <div class="font-medium text-gray-700">
                            C$ {{ (finance.value + (finance.discount ?? 0)).toLocaleString('en-US') }}
                        </div>
                        <div class="text-red-400 mt-1 text-xs" v-if="finance.discount">
                            -C$ {{ finance.discount.toLocaleString('en-US') }}
                        </div>
                        <div class="text-gray-400" v-if="finance.quantity > 1">
                            cant. {{ finance.quantity }}
                        </div>
                    </td>
                    <td>
                        <span :class="[type == 'incomes' ? 'badge-blue' : 'badge-danger']">
                            C$ {{ (finance.value * finance.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                    <td>
                        <span tooltip="Eliminar" role="button" @click="confirmDestroy(finance.id)">
                            <IconTrash />
                        </span>
                    </td>
                </tr>
                <tr v-if="data.data.length == 0">
                    <td colspan="7" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="data.links" />
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import ConceptInformation from '@/Components/ConceptInformation.vue';
import DateColumn from '@/Components/DateColumn.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import { watch, reactive, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { IconTrash } from '@tabler/icons-vue';
import { toast } from "@/Use/toast.js";
import useNotify from '@/Use/notify.js';
import CardInfo from '@/Components/CardInfo.vue';

const props = defineProps({
    data: {
        type: Object, required: true
    },
    type: {
        type: String, required: true
    },
    total: {
        type: Number, required: true
    },
    plans: {
        type: Number, required: false
    },
    concepts: {
        type: Object, required: false
    }
})

const searchParams = new URLSearchParams(window.location.search);

const queryParams = reactive({
    from: searchParams.get("from") ?? null,
    to: searchParams.get("to") ?? null,
    search: searchParams.get("search") ?? '',
    type: props.type
})

const debouncedSearch = debounce(() => {
    let params = { ...route().params, ...queryParams };

    for (const key in params) {
        if (!params[key]) delete params[key];
    }

    router.get(route('dashboard.finances.index'), params, {
        preserveState: true,
        preserveScroll: true,
        only: ['data', 'total', 'plans', 'concepts'],
    })
}, 500)

watch(() => queryParams, debouncedSearch, { deep: true })

const types = {
    incomes: "Ingresos",
    expenditures: "Egresos"
}

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: types[props.type], route: 'dashboard.finances.index', params: { type: props.type } },
]

function confirmDestroy(id) {
    useNotify().confirm(() => {
        router.delete(route(`dashboard.${props.type}.destroy`, id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Registro eliminado correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar este registro?')
}

const stats = computed(() => {
    return [
        {
            title: 'Total',
            value: `C$ ${props.total.toLocaleString()}`
        },
        {
            title: 'Registros',
            value: `${props.data.total}`
        },
        {
            title: "Planes",
            value: `${props.plans}`
        }
    ]
})

</script>
