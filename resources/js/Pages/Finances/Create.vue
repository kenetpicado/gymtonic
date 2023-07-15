<template>
    <AppLayout title="Customer">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="saveFinance">
                <template #title>
                    Informacion del {{ spanishType[type] }}
                </template>

                <template #description>
                    Ingrese los datos del nuevo {{ spanishType[type] }}
                </template>

                <template #form>
                    <SelectForm text="Concept" v-model="dynamicModel" name="model_id">
                        <option selected value="">Ninguno</option>
                        <option v-for="concept in concepts" :value="concept.id">{{ concept.name }}</option>
                    </SelectForm>

                    <InputForm text="Write custom" v-model="form.concept" :disabled="disableCustomConcept" name="concept"/>

                    <InputForm text="Description (optional)" name="description" v-model="form.description"/>

                    <InputForm text="Quantity" v-model="form.quantity" type="number"/>

                    <InputForm text="Value" v-model="form.value"/>

                    <InputForm v-if="type == 'incomes'" text="Discount" v-model="form.discount"/>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                    <pre>{{form}}</pre>
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

const modelTypeId = props.type === 'incomes' ? { incomeable_id: null } : { expenditureable_id: null }
const modelType = props.type === 'incomes' ? { incomeable_type: null } : { expenditureable_type: null }

const form = useForm({
    id: null,
    quantity: 1,
    value: 0,
    discount: 0,
    concept: '',
    description: '',
    ...modelTypeId,
    ...modelType
})

const spanishType = {
    incomes: "Ingreso",
    expenditures: "Egreso"
}

const total = computed(() => {
    if (isNaN(form.value) || isNaN(form.quantity)) {
        return 0
    }

    return form.value * form.quantity - form.discount
})

function saveFinance() {
    if (form.incomeable_id) {
        form.incomeable_type = "App\\Models\\Concept"
    }

    if (form.expenditureable_id) {
        form.expenditureable_type = "App\\Models\\Concept"
    }

    form.post(route(`dashboard.${props.type}.store`), {
        onSuccess: () => {
            router.visit(route('dashboard.finances.index', props.type))
        }
    })
}

const disableCustomConcept = computed(() => {
    if (form.incomeable_id || form.expenditureable_id)
        return true;
});

const dynamicModel = computed({
    get() {
        if (props.type === 'incomes') {
            return form.incomeable_id
        } else {
            return form.expenditureable_id
        }
    },

    set(val) {
        form.concept = ''

        if (props.type === 'incomes') {
            form.incomeable_id = val
        } else {
            form.expenditureable_id = val
        }
    },
});

</script>