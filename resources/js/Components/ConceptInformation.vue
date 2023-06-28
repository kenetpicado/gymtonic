<template>
    <div class="flex gap-3 font-normal text-gray-900 items-center">
        <div style="background-color: #eef2ff; color:#4f46e5"
            class="rounded-full h-10 w-10 flex items-center justify-center">
            <component :is="getIcon(concept.name)"></component>
        </div>

        <div class="text-sm">
            <div class="font-medium text-gray-700">{{ concept.name }}</div>
        </div>
    </div>
</template>

<script setup>
import { IconDroplet, IconBottle, IconBolt, IconWifi, IconShoppingCart, IconBrandFacebook, IconUserDollar, IconSpray, IconBarbell } from '@tabler/icons-vue';

const props = defineProps({
    concept: {
        type: Object, required: true
    }
})

function getIcon(name) {
    switch (name) {
        case 'Agua':
            return IconDroplet;
        case 'Bebidas':
            return IconBottle;
        case 'Energia':
            return IconBolt;
        case 'Internet':
            return IconWifi;
        case 'Tienda':
            return IconShoppingCart;
        case 'Publicidad':
            return IconBrandFacebook;
        case 'Limpieza':
            return IconUserDollar;
        case 'Articulos de limpieza':
            return IconSpray;
        case 'Equipo y maquinaria':
            return IconBarbell;
        default:
            return IconDroplet;
    }
}

</script>