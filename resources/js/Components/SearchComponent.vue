<template>
    <div class="w-1/3 mb-6">
        <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
            type="search" placeholder="Search" @input="onInput($event.target.value)" />
    </div>
</template>

<script setup>
import { debounce } from 'lodash';
// import { Inertia } from "@inertiajs/inertia";

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

const emit = defineEmits(['search'])

const onInput = debounce((value) => {
    if (props.url && props.only) {
        // Inertia.get(props.url, { search: value }, {
        //     preserveState: true,
        //     preserveScroll: true,
        //     only: props.only,
        //     replace: true,
        // });
    } else {
        emit('search', value)
    }
}, 500)

</script>
