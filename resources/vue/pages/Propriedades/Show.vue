<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, Divider } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    propriedade: Object,
});
</script>

<template>

    <Head title="Detalhes da Propriedade" />
    <Card class="shadow-lg max-w-4xl mx-auto">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-green-100 text-green-600 rounded-full p-3 flex items-center justify-center">
                        <i class="pi pi-map-marker text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ propriedade.nome }}</h1>
                        <p class="text-sm text-gray-500">de {{ propriedade.produtor.nome }}</p>
                    </div>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <Link :href="route('propriedades.edit', propriedade.id)" class="w-full sm:w-auto">
                    <Button label="Editar" icon="pi pi-pencil" class="p-button-outlined w-full" />
                    </Link>
                </div>
            </div>
        </template>
        <template #content>
            <Divider />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-4 text-gray-700">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Dados da Propriedade</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Município/UF:</span>
                            <span>{{ propriedade.municipio }} - {{ propriedade.uf }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Inscrição Estadual:</span>
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ propriedade.inscricao_estadual ||
                                'Não informada' }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Área Total:</span>
                            <span>{{ propriedade.area_total }} ha</span>
                        </li>
                    </ul>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Rebanhos</h3>
                    <ul v-if="propriedade.rebanhos && propriedade.rebanhos.length > 0" class="space-y-2">
                        <li v-for="rebanho in propriedade.rebanhos" :key="rebanho.id" class="flex items-center gap-2">
                            <i class="pi pi-twitter text-gray-500"></i>
                            <span>{{ rebanho.especie }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-500 italic">Nenhum rebanho vinculado.</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Unidades de Produção</h3>
                    <ul v-if="propriedade.unidadesProducao && propriedade.unidadesProducao.length > 0"
                        class="space-y-2">
                        <li v-for="up in propriedade.unidadesProducao" :key="up.id" class="flex items-center gap-2">
                            <i class="pi pi-twitter text-gray-500"></i>
                            <span>{{ up.nome_cultura }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-500 italic">Nenhuma unidade de produção vinculado.</p>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-end pt-4">
                <Link :href="route('propriedades.index')">
                <Button label="Voltar para a Lista" icon="pi pi-arrow-left" class="p-button-text" />
                </Link>
            </div>
        </template>
    </Card>
</template>