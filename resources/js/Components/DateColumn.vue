<template>
    <div class="font-medium" tooltip="Hola">
        <div class="text-gray-700 mb-1">{{ formatDate(date) }}</div>
        <div class="text-gray-400 text-xs"> ({{ formatDateToHuman(date) }})</div>
    </div>
</template>

<script setup>
import { Datep } from '@/Classes/Datep.js';

const props = defineProps({
    date: {
        type: String, required: true
    }
})

function formatDate(date) {
    return new Datep(date).format('d/m/Y');
}

function formatDateToHuman(date) {
    return new Datep(date).diffForHumans()
}

</script>