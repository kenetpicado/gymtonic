<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputForm from "@/Components/Form/InputForm.vue"
import { toast } from "@/Use/toast.js"

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset()
            toast.success('Contraseña actualizada correctamente');
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Actualizar contraseña
        </template>

        <template #description>
            Asegúrese que su cuenta este usando una contraseña larga y aleatoria para mantenerse seguro.
        </template>

        <template #form>
            <InputForm text="Contraseña actual" v-model="form.current_password" type="password"/>
            <InputForm text="Nueva contraseña" name="password" v-model="form.password" type="password"/>
            <InputForm text="Confirmar contraseña" name="password_confirmation" v-model="form.password_confirmation" type="password"/>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
