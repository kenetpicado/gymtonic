<script setup>
import { Link, router, useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputForm from "@/Components/Form/InputForm.vue"
import { toast } from "@/Use/toast.js"

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
});

const updateProfileInformation = () => {
    form.put(route('user-profile-information.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success('Perfil actualizado correctamente!!');
        },
    });
};

</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Informacion del perfil
        </template>

        <template #description>
            Actualizar nombre y correo electronico.
        </template>

        <template #form>
            <InputForm text="Name" v-model="form.name"/>
            <InputForm text="Email" v-model="form.email"/>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
