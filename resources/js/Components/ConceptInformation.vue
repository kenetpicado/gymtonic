<template>
    <div class="flex gap-3 font-normal text-gray-900 items-center">
        <div style="background-color: #eef2ff; color:#4f46e5"
            class="rounded-full h-10 w-10 flex items-center justify-center">
            <component :is="conceptComponents[concept.name] ?? DEFAULT_ICON"></component>
        </div>

        <div class="text-sm">
            <div class="font-medium text-gray-700">{{ concept.name }}</div>
        </div>
    </div>
</template>

<script setup>
import { conceptComponents, DEFAULT_ICON } from '@/Use/conceptIcons';

const props = defineProps({
    concept: {
        type: Object, required: true
    }
})

</script>