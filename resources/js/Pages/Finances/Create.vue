<template>
    <AppLayout title="Customer">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="save">
                <template #title>
                    Informacion del {{ types[type] }}
                </template>

                <template #description>
                    Ingrese los datos del nuevo {{ types[type] }}
                </template>

                <template #form>
                    <SelectForm text="Concepto" v-model="form.model_id" name="model_id" required>
                        <option v-for="concept in concepts" :value="concept.id">{{ concept.name }}</option>
                    </SelectForm>

                    <InputForm text="Descripcion (opcional)" name="description" v-model="form.description"
                        autocomplete="on" />

                    <InputForm text="Cantidad" name="quantity" v-model="form.quantity" type="number" />

                    <InputForm text="Monto" name="value" v-model="form.value" type="number" />

                    <InputForm v-if="type == 'incomes'" text="Descuento" name="discount" v-model="form.discount" type="number" />

                    <div class="text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.incomes.index'))">
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
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputForm from '@/Components/Form/InputForm.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import SelectForm from "@/Components/Form/SelectForm.vue"

const props = defineProps({
    concepts: {
        type: Object, required: true
    },
    type: {
        type: String, required: true
    },
})

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    discount: 0,
    concept: '',
    description: '',
    model_id: '',
})

const types = {
    incomes: "Ingreso",
    expenditures: "Egreso"
}

const total = computed(() => {
    if (isNaN(form.value) || isNaN(form.quantity)) {
        return 0
    }

    return form.value * form.quantity - form.discount
})

function save() {
    form.post(route(`dashboard.${props.type}.store`), {
        onSuccess: () => {
            router.visit(route('dashboard.finances.index', props.type))
        }
    })
}

</script>
