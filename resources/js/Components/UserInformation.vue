<template>
    <div class="flex gap-3 font-normal text-gray-900 items-center">
        <div class="h-10 w-10">
            <img class="h-full w-full rounded-full object-cover object-center" :src="profileUrl.get(user.name ?? 'user')"
                alt="" />
        </div>
        <div class="text-sm">
            <div class="font-medium text-gray-700 cut-long-text">{{ user.name ?? '' }}</div>
            <div class="text-gray-400" v-if="user.phone">{{ user.phone }}</div>
        </div>
    </div>
</template>

<script setup>
import useProfileUrl from '@/Composables/useProfileUrl.js';

const props = defineProps({
    user: {
        type: Object, required: true
    }
})

const profileUrl = useProfileUrl();

</script>

<style>
.cut-long-text {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 15ch;
}
</style>