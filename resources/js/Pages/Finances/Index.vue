<template>
    <AppLayout title="Dashboard" :breads="breads">

        <TableSection>
            <template #topbar>
                <SearchComponent :url="route('dashboard.finances.index', type)" :only="['finances']"></SearchComponent>
                <PrimaryButton type="button" @click="$inertia.visit(route('dashboard.finances.create', type))">
                    Nuevo
                </PrimaryButton>
            </template>

            <template #header>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Descripcion</th>
                <th>Monto</th>
                <th>Total</th>
            </template>

            <template #body>
                <tr v-for="(finance, index) in finances.data" class="hover:bg-gray-50">
                    <td>
                        <DateColumn :date="finance.created_at" />
                    </td>
                    <td>
                    	<template v-if="finance.incomeable">
	                        <ConceptInformation v-if="finance.incomeable_type == 'App\\Models\\Concept'"
	                            :concept="finance.incomeable" />

	                        <UserInformation v-else
                            	:user="finance.incomeable" :type="finance.incomeable_type"/>
                    	</template>

                    	<template v-if="finance.expenditureable">
                    		<ConceptInformation v-if="finance.expenditureable_type == 'App\\Models\\Concept'"
	                            :concept="finance.expenditureable" />

                    		<UserInformation v-else
                            	:user="finance.expenditureable" :type="finance.expenditureable_type" />
                    	</template>
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
                        <span class="badge-blue">
                            C$ {{ (finance.value * finance.quantity).toLocaleString('en-US') }}
                        </span>
                    </td>
                </tr>
                <tr v-if="finances.data.length == 0">
                    <td colspan="6" class="text-center">No data to display</td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="finances.links"></ThePaginator>
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
import ConceptInfo from '@/Components/ConceptInfo.vue';
import DateColumn from '@/Components/DateColumn.vue';

const props = defineProps({
    finances: {
        type: Object, required: true
    },
    type: {
    	type: String, required: true
    }
})

const spanishType = {
	incomes: "Ingresos",
	expenditures: "Egresos"
}

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: spanishType[props.type], route: 'dashboard.finances.index', params: props.type },
]

</script>
