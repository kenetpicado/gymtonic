<template>
    <aside class="w-72 min-h-screen p-0 m-0 bg-white flex flex-col border">
        <div class="h-full px-3 py-4 overflow-y-auto">
            <div class="flex flex-col items-center my-6">
                <div class="h-14 w-14">
                    <img class="h-full w-full" src="/img/logo-ag.png" alt="" />
                </div>
            </div>
            <ul class="space-y-1">
                <li v-for="item in items">
                    <span v-if="item.header"
                        class="block text-xs text-gray-500 uppercase tracking-wider font-semibold mt-6 px-2">
                        {{ item.header }}
                    </span>
                    <Link v-else :href="item.route">
                    <span class="flex items-center px-2 py-3 rounded-xl gap-4" :class="getClass(item.route)">
                        <component :is="item.icon ?? DEFAULT_ICON"></component>
                        <span>{{ item.name }}</span>
                    </span>
                    </Link>
                </li>
                <li>
                    <span @click="logout" class="flex items-center px-2 py-3 rounded-lg gap-4 hover:bg-indigo-50"
                        role="button">
                        <IconLogout></IconLogout>
                        <span>Salir</span>
                    </span>
                </li>
            </ul>
        </div>
    </aside>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3';
import { IconHome, IconLogout, IconUser, IconUsersGroup, IconRun, IconStack, IconActivity, IconMoneybag, IconCurrencyDollarOff, IconBellZ, IconLayoutList } from '@tabler/icons-vue';
import { IconNote } from '@tabler/icons-vue';
import {Carbon} from "../Classes/Carbon";

const DEFAULT_ICON = IconUser;

const logout = () => {
    router.post(route('logout'));
};

const items = [
    {
        name: 'Inicio',
        route: route('dashboard.index'),
        icon: IconHome
    },
    {
        header: 'Administración'
    },
    {
        name: 'Clientes',
        route: route('dashboard.customers.index'),
        icon: IconUser
    },
    {
        name: 'Planes',
        route: route('dashboard.plans.index'),
        icon: IconRun
    },
    {
        name: 'Expirados',
        route: route('dashboard.plans.expired'),
        icon: IconBellZ
    },
    {
        name: 'Personal',
        route: route('dashboard.employees.index'),
        icon: IconUsersGroup
    },
    {
        header: 'Sistema'
    },
    {
        name: 'Usuarios',
        route: route('dashboard.users.index'),
        icon: IconUsersGroup
    },
    {
        name: 'Servicios',
        route: route('dashboard.services.index'),
        icon: IconActivity
    },
    {
        name: 'Notas',
        route: route('dashboard.notes.index'),
        icon: IconNote
    },
    {
        header: 'Finanzas'
    },
    {
        name: 'Conceptos',
        route: route('dashboard.concepts.index'),
        icon: IconStack
    },
    {
        name: 'Ingresos',
        route: route('dashboard.finances.index', { type: 'incomes', from: Carbon.today(), to: Carbon.today() }),
        icon: IconMoneybag
    },
    {
        name: 'Egresos',
        route: route('dashboard.finances.index', { type: 'expenditures', from: Carbon.today(), to: Carbon.today() }),
        icon: IconCurrencyDollarOff
    },
    {
        name: 'Resumen',
        route: route('dashboard.summary.index'),
        icon: IconLayoutList
    },
    {
        header: 'Cuenta'
    },
    {
        name: 'Perfil',
        route: route('dashboard.profile.index')
    },
]

function getClass(fullRoute) {
    return window.location.href == fullRoute
        ? 'bg-gray-800 text-white'
        : 'hover:bg-gray-100';
}

</script>
