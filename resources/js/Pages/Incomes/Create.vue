<template>
    <AppLayout title="Customer">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Incomes
            </h2>
        </template>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection @submitted="saveIncome">
                <template #title>
                    Income Information
                </template>

                <template #description>
                    Set the income's information.
                </template>

                <template #form>
                    <InputForm text="Concept" v-model="form.concept"></InputForm>
                    <InputForm text="Description (optional)" name="description" v-model="form.description"></InputForm>
                    <InputForm text="Amount" v-model="form.amount"></InputForm>
                    <InputForm text="Quantity" v-model="form.quantity" type="number"></InputForm>
                    <InputForm text="Discount" v-model="form.discount"></InputForm>

                    <div class="col-span-4 text-lg font-medium text-gray-900">
                        Total: C$ {{ total }}
                    </div>
                </template>

                <template #actions>
                    <SecondaryButton @click="$inertia.visit(route('dashboard.incomes.index'))">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
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

const form = useForm({
    amount: 0,
    quantity: 1,
    concept: '',
    description: '',
    discount: 0,
})

const total = computed(() => {
    if (isNaN(form.amount) || isNaN(form.quantity)) {
        return 0
    }

    return form.amount * form.quantity - form.discount
})

function saveIncome() {
    form.post(route('dashboard.incomes.store'), {
        onSuccess: () => {
            router.visit(route('dashboard.incomes.index'))
        }
    })
}

</script>