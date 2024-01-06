<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputForm from "@/Components/Form/InputForm.vue"

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Ingresar" />

    <AuthenticationCard>
        <div class="flex flex-col justify-center items-center mb-4">
            <img src="/img/logo-ag.png" alt="" class="w-16 h-16 mb-4">
            <h1 class="text-lg font-bold">{{ $page.props.appName }}</h1>
        </div>

        <form @submit.prevent="submit">
            <InputForm text="Correo" v-model="form.email" autofocus required type="email" autocomplete="on" />
            <InputForm text="Contraseña" v-model="form.password" required type="password" />

            <Checkbox v-model:checked="form.remember" text="Recordarme" />

            <div class="mt-10">
                <PrimaryButton class="w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
