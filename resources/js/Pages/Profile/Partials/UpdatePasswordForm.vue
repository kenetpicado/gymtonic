<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputForm from "@/Components/Form/InputForm.vue"
import { toast } from "@/Use/toast.js"

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            form.reset()
            toast.success('Contrasena actualizada correctamente!!');
        },
        onError: (err) => {
            console.log(err)
        },
    });
};
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title>
            Update Password
        </template>

        <template #description>
            Ensure your account is using a long, random password to stay secure.
        </template>

        <template #form>
            <InputForm text="Current Password" v-model="form.current_password"/>
            <InputForm text="New Password" name="password" v-model="form.password"/>
            <InputForm text="Confirm Password" name="password_confirmation" v-model="form.password_confirmation"/>
            <pre>{{form}}</pre>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Guardar
            </PrimaryButton>
        </template>
    </FormSection>
</template>
