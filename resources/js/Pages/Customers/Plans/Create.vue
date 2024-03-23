<template>
    <AppLayout title="Customer" :breads="breads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Plan
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="submit">
                <template #title>
                    Informacion del plan
                </template>

                <template #description>
                    <div class="mt-3">
                        Cliente: <span class="uppercase"> {{ props.customer.name }}</span>
                    </div>
                    <div>
                        Estado del plan: <span class="uppercase"> {{ isCurrentActive ? 'Activo' : 'Expirado' }}</span>
                    </div>
                    <div class="bg-white shadow-lg min-w-full text-xs font-mono py-4 px-3 text-gray-500">
                        <img src="/img/logo-ag.png" alt="" class="w-14 h-14 mb-2 mx-auto">
                        <div class="text-center mb-2">
                            <h1>{{ $page.props.appName }}</h1>
                            <div class="text-center my-2">
                                -------------------------
                            </div>
                            <div>RUC: 0000000</div>
                            <div>C4WC+G6V, León</div>
                            <div>Tel: 2310-0000</div>
                        </div>
                        <div>Fecha: {{ Carbon.create().format('d/m/Y') }}</div>
                        <div>
                            Cajero: {{ $page.props.user.name }}
                        </div>
                        <div class="text-center my-2">
                            -------------------------
                        </div>
                        <div>Servicio: {{ services.find(s => form.service_id === s.id)?.name }}</div>
                        <div>Periodo: {{ form.period }} dia(s)</div>
                        <div>
                            Inicio: {{ Carbon.create(form.start_date).format('d/m/Y') }}
                        </div>
                        <div>
                            Fin: {{ Carbon.create(form.end_date).format('d/m/Y') }}
                        </div>
                        <div>
                            Descuento: C$ {{ form.discount }}
                        </div>
                        <!-- total -->
                        <div class="text-center my-2">
                            -------------------------
                        </div>
                        <div class="text-center font-bold">
                            Total: C$ {{ total }}
                        </div>
                        <div class="text-center my-2">
                            -------------------------
                        </div>
                        <div class="text-center text-xs">
                            Gracias por su preferencia
                        </div>
                    </div>
                </template>

                <template #form>
                    <div class="grid grid-cols-2 gap-4">
                        <SelectForm v-model="form.service_id" text="Servicio" required name="service_id">
                            <option v-for="service in services" :value="service.id">{{ service.name }}</option>
                        </SelectForm>
                        <SelectForm v-model="form.period" text="Periodo" required>
                            <option value="" selected>Seleccionar periodo</option>
                            <option v-for="price in prices" :value="price.period">
                                {{ periodLabel[price.period] }} - C$ {{ price.value }}
                            </option>
                        </SelectForm>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <InputForm text="Inicio del plan" v-model="form.start_date" type="date" />
                        <InputForm text="Fin del plan" v-model="end_date" type="date" disabled />
                    </div>

                    <div v-if="!isCurrentActive && plan" class="mb-4">
                        <div class="mb-3 text-indigo-400">
                            El plan anterior finalizó el {{ Carbon.create(plan.end_date).format('d/m/Y') }}
                        </div>
                        <Checkbox v-model:checked="startFromLastPlan" text="Continuar el plan anterior"
                            class="col-span-4" />
                    </div>

                    <InputForm text="Descuento C$ (Beca)" v-model="form.discount" type="number"></InputForm>
                    <InputForm text="Nota" v-model="form.note"></InputForm>

                    <div class="block col-span-4 mb-4">
                        <Checkbox v-model:checked="form.save_note" text="Guardar en notas" />
                    </div>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.customers.index'))">
                        Cancelar
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Guardar
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';
import Checkbox from '@/Components/Checkbox.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import SelectForm from "@/Components/Form/SelectForm.vue";
import FormSection from '@/Components/FormSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { periodLabel } from '@/Use/periodLabel.js';
import { toast } from '@/Use/toast.js';
import { useForm } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    services: {
        type: Object, required: false
    },
    plan: {
        type: Object, required: false
    },
    customer: {
        type: Object, required: true
    },
    isCurrentActive: {
        type: Boolean, required: true
    },
})

const startFromLastPlan = ref(false)

const form = useForm({
    plan_id: props.plan?.id,
    price: props.plan?.price ?? 0,
    period: props.plan?.period,
    start_date: props.isCurrentActive ? Carbon.create(props.plan.end_date).addDays(1).format() : Carbon.today(),
    end_date: props.plan?.end_date,
    discount: props.plan?.discount ?? 0,
    note: props.plan?.note ?? "",
    service_id: props.plan?.service_id ?? props.services[0].id,
    save_note: false,
});

const breads = [
    { name: 'Inicio', route: 'dashboard.index' },
    { name: 'Clientes', route: 'dashboard.customers.index' },
    { name: 'Pagar', route: 'dashboard.customers.plans.create', params: [props.customer.id] },
]

//Obtener los precios del servicio seleccionado
const prices = computed(() => {
    return props.services.find(service => service.id == form.service_id)?.prices ?? [];
});

//Calcular el total del plan
const total = computed(() => {
    if (!form.period) return 0;
    return prices.value.find(price => price.period == form.period)?.value - form.discount;
});

watch(() => form.service_id, () => {
    if (!prices.value.find(price => price.period == form.period)) {
        form.period = prices.value[prices.value.length - 1].period;
    }
}, { immediate: true });

watch(() => startFromLastPlan.value, (value) => {
    if (value) {
        form.start_date = Carbon.create(props.plan.end_date).addDays(1).format();
    } else {
        form.start_date = Carbon.today();
    }
});

const end_date = computed(() => {
    return Carbon.create(form.start_date).addPeriod(parseInt(form.period)).addDays(-1).format();
});

function submit() {
    form.price = total.value;
    form.end_date = end_date.value;

    form.post(route('dashboard.customers.plans.store', props.customer.id), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Guardado');
        },
    });
}

</script>