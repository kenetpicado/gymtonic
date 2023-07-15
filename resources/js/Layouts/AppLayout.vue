<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Sidebar from './Sidebar.vue';
import { IconChevronRight } from '@tabler/icons-vue';
import { getAvatarUrl } from "@/Use/helpers.js"

defineProps({
    title: String,
    breads: Array,
});

function getClass(routeName) {
    return route().current(routeName)
        ? 'text-gray-500'
        : 'text-gray-800';
}

</script>

<template>
    <div class="flex">

        <Head :title="title" />

        <Sidebar />

        <div class="bg-gray-100 w-full">

            <header class="bg-white mb-4">
                <div class="max-w-7xl mx-auto h-20 py-4 px-4 px-8 flex justify-between items-center">
                    <ol class="flex items-center">
                        <li class="flex items-center" v-for="(bread, index) in breads">
                            <IconChevronRight v-if="index != 0" class="text-gray-300" />
                            <Link :href="route(bread.route, bread.params)">
                            <span class="text-sm mx-2 tracking-wider" :class="getClass(bread.route)">
                                {{ bread.name }}
                            </span>
                            </Link>
                        </li>
                    </ol>
                    <div>
                        <div class="h-10 w-10">
                            <img class="h-full w-full rounded-full object-cover object-center" :src="getAvatarUrl($page.props.auth.user.name)"
                                alt="" />
                        </div>
                    </div>
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>

    </div>
</template>