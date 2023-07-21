<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue';

const breads = [
    { name: 'Dashboard', route: 'dashboard.index' },
    { name: 'Perfil', route: 'dashboard.profile.index' },
]

</script>

<template>
    <AppLayout title="Profile" :breads="breads">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <UpdateProfileInformationForm :user="$page.props.user" />

            <SectionBorder />

            <UpdatePasswordForm class="mt-10 sm:mt-0" />

            <SectionBorder />
        </div>
    </AppLayout>
</template>
