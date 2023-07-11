<template>
    <AppLayout title="Customer">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="saveIncome">
                <template #title>
                    Informacion del Ingreso
                </template>

                <template #description>
                    Ingrese los datos del nuevo ingreso
                </template>

                <template #form>
                    <SelectForm text="Concept" v-model="form.concept">
                        <option selected value="">Ninguno</option>
                        <option v-for="concept in concepts">{{ concept.name }}</option>
                    </SelectForm>
                    <InputForm text="Or write another" v-model="form.concept"/>
                    <InputForm text="Description (optional)" name="description" v-model="form.description"/>
                    <InputForm text="Quantity" v-model="form.quantity" type="number"/>
                    <InputForm text="Value" v-model="form.value"/>
                    <InputForm text="Discount" v-model="form.discount"/>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
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
})

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    discount: 0,
    concept: '',
    description: '',
    incomeable_id: null,
    incomeable_type: null
})

const total = computed(() => {
    if (isNaN(form.value) || isNaN(form.quantity)) {
        return 0
    }

    return form.value * form.quantity - form.discount
})

function saveIncome() {
    form.post(route('dashboard.incomes.store'), {
        onSuccess: () => {
            router.visit(route('dashboard.incomes.index'))
        }
    })
}

</script>