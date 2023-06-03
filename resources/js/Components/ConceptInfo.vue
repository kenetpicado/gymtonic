<template>
    <div class="text-sm">
        <div class="font-medium mb-1">
            <span class="text-gray-700">{{ type.created_at_formatted }}</span>
            <span class="text-gray-400"> ({{ diffForHumans(type.created_at) }})</span>
        </div>
        <div class="text-sm">
            <div class="font-medium text-gray-700 mb-1">
                {{ type.concept }}
            </div>
            <div class="text-gray-400" v-if="type.description">
                {{ type.description }}
            </div>
        </div>
    </div>
</template>

<script setup>

import useHumanDate from '@/Composables/useHumanDate';

const props = defineProps({
    type: {
        type: Object, required: true
    }
})

const { diffForHumans } = useHumanDate();

</script>