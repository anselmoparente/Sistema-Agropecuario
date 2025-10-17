<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Card } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });
</script>

<template>

    <Head title="Início"></Head>

    <Card class="shadow-lg">
        <template #title>
            <h1 class="text-2xl font-bold text-gray-800">Página Inicial</h1>
        </template>
        <template #content>
            <div class="text-center py-8">
                <p class="text-xl text-gray-700 mb-4">Bem-vindo ao AgroSystem!</p>
                <p class="text-gray-500 mb-8">Utilize o menu lateral para navegar pelas funcionalidades do sistema.</p>
            </div>
        </template>
    </Card>
</template>

<style scoped></style>