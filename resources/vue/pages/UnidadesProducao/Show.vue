<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, Divider } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    up: Object,
});
</script>

<template>

    <Head :title="`Detalhes de ${up.nome_cultura}`" />
    <Card class="shadow-lg max-w-4xl mx-auto">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-yellow-100 text-yellow-600 rounded-full p-3 flex items-center justify-center">
                        <i class="pi pi-th-large text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ up.nome_cultura }}</h1>
                        <p class="text-sm text-gray-500">
                            em {{ up.propriedade.nome }} de {{ up.propriedade.produtor.nome }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <Link :href="route('unidades-producao.edit', up.id)" class="w-full sm:w-auto">
                    <Button label="Editar" icon="pi pi-pencil" class="p-button-outlined w-full" />
                    </Link>
                </div>
            </div>
        </template>
        <template #content>
            <Divider />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-4 text-gray-700">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Dados da Unidade de Produção</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Propriedade:</span>
                            <span>{{ up.propriedade.nome }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Área Total:</span>
                            <span>{{ up.area_total_ha || 'Não informada' }} ha</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Coordenadas:</span>
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ up.coordenadas_geograficas ||
                                'Não informada' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-end pt-4">
                <Link :href="route('unidades-producao.index')">
                <Button label="Voltar para a Lista" icon="pi pi-arrow-left" class="p-button-text" />
                </Link>
            </div>
        </template>
    </Card>
</template>
