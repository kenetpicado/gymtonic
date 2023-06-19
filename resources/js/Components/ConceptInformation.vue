<template>
    <div class="flex gap-3 font-normal text-gray-900 items-center">
        <div class="h-10 w-10">
            <img class="h-full w-full rounded-full object-cover object-center" :src="concept.image"
                alt="" />
        </div>
        <div class="text-sm">
            <div class="font-medium text-gray-700">{{ concept.name }}</div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    concept: {
        type: Object, required: true
    }
})

</script>