<template>
    <AppLayout title="Dashboard" :breads="breads">

        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.finances.index', type)" :only="['finances']"></SearchComponent>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.finances.create', type))">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #options>
                <div class="bg-indigo-100 border-l-4 border-indigo-600 text-indigo-600 p-4" role="alert">
                  <template v-if="from == to">
                        {{ props.type == "incomes" ? "Ingresos" : "Egresos" }} de hoy:
                    </template>
                    <template v-else>
                        {{ props.type == "incomes" ? "Ingresos" : "Egresos" }} desde
                        {{ Carbon.create(from).format("d de F") }} hasta el
                        {{ Carbon.create(to).format("d de F")  }}:
                    </template>
                    C$ {{ total.toLocaleString() }}
                </div>
                <div class="px-3 py-4 flex gap-4">
                    <InputForm v-model="from" text="Desde" type="date" style="width: 17rem;" />
                    <InputForm v-model="to" text="Hasta" type="date" style="width: 17rem;" />
                </div>
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Total</th>
                <th>Actions</th>
            </template>

            <template #body>
                <tr v-for="(finance, index) in finances" class="hover:bg-gray-50">
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
                <tr v-if="finances.length == 0">
                    <td colspan="6" class="text-center">No data to display</td>
                </tr>
            </template>
        </TableSection>
    </AppLayout>
</template>

<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchComponent from '@/Components/SearchComponent.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TableSection from '@/Components/TableSection.vue';
import UserInformation from '@/Components/UserInformation.vue';
import ConceptInformation from '@/Components/ConceptInformation.vue';
import DateColumn from '@/Components/DateColumn.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import { ref, watch, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { IconTrash } from '@tabler/icons-vue';
import { toast } from "@/Use/toast.js";
import useNotify from '@/Use/notify.js';
import { Carbon } from "@/Classes/Carbon";

const props = defineProps({
    finances: {
        type: Object, required: true
    },
    type: {
        type: String, required: true
    },
    from_date: {
        type: String, required: true
    },
    to_date: {
        type: String, required: true
    }
})

const from = ref(props.from_date)
const to = ref(props.to_date)

const total = computed(() => {
    return props.finances.reduce((acc, finance) => acc + finance.value * finance.quantity, 0)
})

watch(() => [from.value, to.value], ([from_value, to_value]) => {
    if (from_value && to_value) {
        onFilter(from_value, to_value)
    }
})

const onFilter = debounce((from_value, to_value) => {
    router.get(route('dashboard.finances.index', props.type), {
        from: from_value,
        to: to_value
    }, {
        preserveState: true,
        preserveScroll: true,
        only: ['finances'],
    })
}, 500)

const spanishType = {
    incomes: "Ingresos",
    expenditures: "Egresos"
}

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
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
