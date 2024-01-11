<script setup>
import { computed, useSlots } from 'vue';
import SectionTitle from './SectionTitle.vue';

defineEmits(['submitted']);

const hasActions = computed(() => !!useSlots().actions);
</script>

<template>
    <div class="grid grid-cols-3 md:gap-6">
        <SectionTitle>
            <template #title>
                <slot name="title" />
            </template>
            <template #description>
                <div class="col-span-4 space-y-3 text-lg">
                    <slot name="description" />
                </div>
            </template>
        </SectionTitle>

        <div class="mt-0 col-span-2">
            <form @submit.prevent="$emit('submitted')">

                <div class="p-4 bg-white sm:p-6">
                    <div class="flex flex-col">
                        <slot name="form" />
                    </div>
                </div>

                <div v-if="hasActions"
                    class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md gap-4">
                    <slot name="actions" />
                </div>
            </form>
        </div>
    </div>
</template>
