<template>
    <AppLayout :title="spanishType[props.type]" :breads="breads">

        <TableSection>
            <template #topbar>
                <h1 class="text-2xl font-extrabold text-gray-600">
                    {{ spanishType[props.type] }}
                </h1>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.finances.create', type))">
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
                    <CardInfo :stat="{ value: `C$ ${total.toLocaleString()}`, title: 'Total' }" />
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
                <tr v-for="(finance, index) in finances.data" class="hover:bg-gray-50">
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

                            <UserInformation v-else :user="finance.expenditureable" :type="finance.expenditureable_type" />
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
                <tr v-if="finances.data.length == 0">
                    <td colspan="7" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="finances.links" />
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
import { watch, computed, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { IconTrash } from '@tabler/icons-vue';
import { toast } from "@/Use/toast.js";
import useNotify from '@/Use/notify.js';
import { Carbon } from "@/Classes/Carbon";
import { defineProps } from 'vue';
import CardInfo from '@/Components/CardInfo.vue';

const props = defineProps({
    finances: {
        type: Object, required: true
    },
    type: {
        type: String, required: true
    },
})

const searchParams = new URLSearchParams(window.location.search);

const queryParams = reactive({
    from: searchParams.get("from") ?? Carbon.today(),
    to: searchParams.get("to") ?? Carbon.today(),
    search: searchParams.get("search") ?? '',
})

const total = computed(() => {
    return props.finances.data.reduce((acc, finance) => acc + finance.value * finance.quantity, 0)
})

const debouncedSearch = debounce(() => {
    for (const key in queryParams) {
        if (!queryParams[key])
            delete queryParams[key]
    }

    router.get(route('dashboard.finances.index', props.type), queryParams, {
        preserveState: true,
        preserveScroll: true,
        only: ['finances'],
    })
}, 500)

watch(() => queryParams, debouncedSearch, { deep: true })

const spanishType = {
    incomes: "Ingresos",
    expenditures: "Egresos"
}

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: spanishType[props.type], route: 'dashboard.finances.index', params: props.type },
]

function confirmDestroy(id) {
    useNotify().confirm(() => {
        router.delete(route('dashboard.finances.destroy', [props.type, id]), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Registro eliminado correctamente!')
            },
        });
    }, '¿Estás seguro de eliminar este registro?')
}

</script>
