<template>
    <div :class="`bg-white shadow-lg h-28 border-s-4 border-indigo-600 rounded-xl`">
        <div class="flex items-center h-full">
            <div class="p-4">
                <div class="text-sm uppercase tracking-wider mb-2 font-semibold text-indigo-500 leading-tight">
                    {{ title }}
                </div>
                <div class="text-4xl font-bold text-gray-800 leading-tight">
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
    }
})

</script>