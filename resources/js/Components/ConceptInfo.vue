<template>
    <div class="font-medium text-gray-700 mb-1">
        {{ type.concept }}
    </div>
    <div class="text-gray-400" v-if="type.description">
        {{ type.description }}
    </div>
</template>

<script setup>

const props = defineProps({
    type: {
        type: Object, required: true
    }
})

</script>