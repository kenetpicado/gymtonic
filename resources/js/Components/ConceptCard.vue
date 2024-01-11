<template>
    <div class="w-full p-6 bg-white shadow-soft-xl rounded-xl">
        <div class="flex flex-col justify-between h-full">
            <div>
                <div class="mb-2">
                    <component :is="conceptComponents[concept.name] ?? DEFAULT_ICON" size="25" class="text-gray-400" />
                </div>
                <h5 class="mb-2 text-xl font-semibold tracking-tight text-gray-900">
                    {{ concept.name }}
                    <IconEdit class="inline-block w-4 h-4" @click="$emit('onEdit', concept)" role="button" />
                </h5>
            </div>
            <p v-if="concept.last_expenditure" class="mb-5 text-sm text-gray-500 mt-1 lowercase">
                últ. pago: {{ Carbon.create(concept.last_expenditure?.created_at).format('d de F') }}
            </p>
            <div class="flex gap-4">
                <Link v-if="concept.has_expenditure" tooltip="Ver los pagos"
                    :href="route('dashboard.concepts.expenditures.index', concept.id)" class="badge-danger">
                Egresos
                </Link>
                <Link v-if="concept.has_income" tooltip="Ver los ingresos"
                    :href="route('dashboard.concepts.incomes.index', concept.id)" class="badge-success">
                Ingresos
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Carbon } from '@/Classes/Carbon.js';
import { conceptComponents, DEFAULT_ICON } from '@/Use/conceptIcons';
import { Link } from '@inertiajs/vue3';
import { IconEdit } from '@tabler/icons-vue';

defineProps({
    concept: {
        type: Object, required: true
    }
})

</script>