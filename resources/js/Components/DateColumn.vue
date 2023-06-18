<template>
    <div class="font-medium" tooltip="Hola">
        <div class="text-gray-700 mb-1">{{ Carbon.create(date).format('d/m/Y') }}</div>
        <div class="text-gray-400 text-xs"> ({{ Carbon.create(date).diffForHumans() }})</div>
    </div>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';

const props = defineProps({
    date: {
        type: String, required: true
    }
})

</script>