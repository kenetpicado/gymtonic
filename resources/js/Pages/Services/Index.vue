<template>
    <AppLayout title="Dashboard" :breads="breads">

        <DialogModal :show="openModal">
            <template #title>
                {{ isNew ? 'Nuevo' : 'Editar' }}
            </template>
            <template #content>
                <InputForm text="Name" v-model="form.name"></InputForm>
                <Checkbox v-model:checked="form.is_active" text="Active" class="my-3" />
                <h4 class="font-bold text-lg">Precios</h4>
                <p class="text-sm text-red-600 mt-1" v-if="$page.props.errors['prices']">
                    {{ $page.props.errors['prices'] }}
                </p>

                <InputForm v-for="(period, index) in savedPeriods" :name="`prices.${index}.value`"
                    :text="period.period_label" v-model="period.value" class="mt-4" type="number"></InputForm>

            </template>
            <template #footer>
                <SecondaryButton @click="resetValues">
                    Cancelar
                </SecondaryButton>
                <PrimaryButton type="button" @click="saveService">
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
                <th>Precios</th>
                <th>Estado</th>
                <th>Acciones</th>
            </template>

            <template #body>
                <tr v-for="service in services.data" class="hover:bg-gray-50">
                    <td>
                        {{ service.id }}
                    </td>
                    <td>
                        {{ service.name }}
                    </td>
                    <td>
                        <span v-for="price in service.prices" class="badge-blue mr-1">
                            {{ periodLabel[price.period] }}: C$ {{ price.value }}
                        </span>
                    </td>
                    <td>
                        <span v-if="service.is_active" class="badge-success">
                            Activo
                        </span>
                        <span v-else class="badge-gray">
                            Inactivo
                        </span>
                    </td>
                    <td>
                        <IconPencil role="button" @click="editService(service)" />
                    </td>
                </tr>
            </template>

            <template #paginator>
                <ThePaginator :links="services.links"></ThePaginator>
            </template>
        </TableSection>

    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThePaginator from '@/Components/ThePaginator.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import { ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import { toast } from '@/Use/toast.js';
import TableSection from '@/Components/TableSection.vue';
import { IconPencil } from '@tabler/icons-vue';
import { periodLabel } from '@/Use/periodLabel.js';

const props = defineProps({
    services: {
        type: Object, required: true
    },
    periods: {
        type: Object,
        required: true
    }
})

const openModal = ref(false)
const isNew = ref(true)

let savedPeriods = props.periods

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Servicios', route: 'dashboard.services.index' },
]

const form = useForm({
    id: null,
    name: '',
    is_active: true,
    prices: []
});

async function editService(service) {
    form.id = service.id
    form.name = service.name
    form.is_active = Boolean(service.is_active)

    savedPeriods.forEach(period => {
        const price = service.prices.find(price => price.period === period.period)
        period.value = price ? price.value : null
    })

    isNew.value = false
    openModal.value = true
}

function resetValues() {
    form.reset()
    form.clearErrors()

    savedPeriods.forEach(period => {
        delete period.value
    })

    isNew.value = true
    openModal.value = false
}

function saveService() {
    form.prices = savedPeriods.filter(period => period.value)

    if (isNew.value) {
        form.post(route('dashboard.services.store'), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Servicio creado correctamente!')
                resetValues()
            },
        });
    } else {
        form.put(route('dashboard.services.update', form.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success('Servicio actualizado correctamente!')
                resetValues()
            },
        });
    }
}

</script>
