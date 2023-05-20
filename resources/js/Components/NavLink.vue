<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    routeName: String,
});

console.log()

const classes = computed(() => {
    return route().current(props.routeName)
        ? 'nav-item-active'
        : 'nav-item';
});
</script>

<template>
    <Link :href="route(routeName)" :class="classes">
        <slot />
    </Link>
</template>
