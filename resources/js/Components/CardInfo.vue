<template>
    <div :class="`bg-white shadow-lg h-28 border-s-4 border-${color} rounded-xl`">
        <div class="flex items-center h-full">
            <div class="p-4">
                <div :class="`text-sm uppercase text-${color} font-bold tracking-wider mb-2`">
                    {{ title }}
                </div>
                <div class="text-4xl font-bold">
                    {{ value }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        default: 'C$ 0',
    },
    color: {
        type: String,
        default: 'indigo-600',
    },
})

</script>