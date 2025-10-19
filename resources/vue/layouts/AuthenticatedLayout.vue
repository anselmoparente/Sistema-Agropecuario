<script setup>
import { Link, router } from '@inertiajs/vue3';

import { Button, Toast } from 'primevue';

const logout = () => router.post(route('logout'));
</script>

<template>
    <Toast position="top-right" />
    <div class="min-h-screen bg-gray-100 flex">
        <aside class="fixed top-0 left-0 h-screen w-64 bg-gray-800 text-white flex flex-col shadow-lg p-4">
            <div class="text-center text-2xl font-bold mb-10 border-b border-gray-700 pb-4 text-gray-300">
                AgroSystem
            </div>

            <nav class="flex-grow flex flex-col space-y-2 overflow-y-auto">
                <Link :href="route('home')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('home') }">
                <i class="pi pi-home mr-3"></i>
                <span>Início</span>
                </Link>
                <Link :href="route('produtores.index')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('produtores.*') }">
                <i class="pi pi-users mr-3"></i>
                <span>Produtores</span>
                </Link>
                <Link :href="route('propriedades.index')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('propriedades.*') }">
                <i class="pi pi-map-marker mr-3"></i>
                <span>Propriedades</span>
                </Link>
                <Link :href="route('rebanhos.index')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('rebanhos.*') }">
                <i class="pi pi-prime mr-3"></i>
                <span>Rebanhos</span>
                </Link>
                <Link :href="route('unidades-producao.index')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('unidades-producao.*') }">
                <i class="pi pi-sitemap mr-3"></i>
                <span>Unidades de Produção</span>
                </Link>
                <Link :href="route('relatorios')"
                    class="flex items-center px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-700"
                    :class="{ 'bg-gray-900 font-semibold': route().current('relatorios') }">
                <i class="pi pi-chart-bar mr-3"></i>
                <span>Relatórios</span>
                </Link>
            </nav>

            <div class="mt-auto border-t border-gray-700 pt-4">
                <Button label="Sair" icon="pi pi-sign-out"
                    class="p-button-danger p-button-text w-full !justify-start !text-gray-400 hover:!bg-red-900/50"
                    @click="logout" />
            </div>
        </aside>

        <div class="flex-1 ml-64 flex flex-col">
            <main class="flex-1 p-6 lg:p-10 overflow-y-auto h-screen">
                <slot></slot>
            </main>
        </div>
    </div>
</template>
