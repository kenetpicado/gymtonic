<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Sidebar from './Sidebar.vue';
import { IconChevronRight } from '@tabler/icons-vue';

defineProps({
    title: String,
    breads: Array,
});

function getClass(routeName) {
    return route().current(routeName)
        ? 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'
        : 'text-gray-700 hover:text-indigo-600';
}

</script>

<template>
    <div class="flex">

        <Head :title="title" />

        <Sidebar />

        <div class="bg-gray-100 w-full">

            <header class="bg-white">
                <div class="max-w-7xl mx-auto h-16 py-4 px-4 px-8 flex justify-between items-center">
                    <ol class="flex items-center">
                        <li class="flex items-center" v-for="(bread, index) in breads">
                            <IconChevronRight v-if="index != 0" class="text-gray-300" />
                            <Link :href="route(bread.route)">
                            <span class="text-sm tracking-wide mx-2" :class="getClass(bread.route)">
                                {{ bread.name }}
                            </span>
                            </Link>
                        </li>
                    </ol>
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard.index')">
                        <ApplicationMark class="block h-9 w-auto" />
                        </Link>
                    </div>
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>

    </div>
</template>