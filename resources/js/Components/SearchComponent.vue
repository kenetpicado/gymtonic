<template>
    <div style="width: 17rem;">
        <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
            type="search" placeholder="Search" @input="onInput($event.target.value)" />
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import { debounce } from 'lodash';
import { reactive } from 'vue';

const props = defineProps({
    url: {
        type: String,
        required: false
    },
    only: {
        type: Array,
        required: false,
    }
})

const queryParam = reactive({
    search: ''
})

const emit = defineEmits(['search'])

const onInput = debounce((value) => {
    if (props.url && props.only) {
        if (value) {
            queryParam.search = value
        } else {
            delete queryParam.search
        }
        router.get(props.url, queryParam, {
            preserveState: true,
            preserveScroll: true,
            only: props.only,
            replace: true,
        });
    } else {
        emit('search', value)
    }
}, 500)

</script>
