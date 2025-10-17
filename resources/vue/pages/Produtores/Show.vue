<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, Divider } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    produtor: Object,
});
</script>

<template>

    <Head title="Visualizar Produtor"></Head>

    <Card class="shadow-lg max-w-4xl mx-auto">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 flex items-center justify-center">
                        <i class="pi pi-user text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ produtor.nome }}</h1>
                        <p class="text-sm text-gray-500">Detalhes do Produtor</p>
                    </div>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <Link :href="route('produtores.edit', produtor.id)" class="w-full sm:w-auto">
                    <Button label="Editar" icon="pi pi-pencil" class="p-button-outlined w-full" />
                    </Link>
                </div>
            </div>
        </template>
        <template #content>
            <Divider />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-4 text-gray-700">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Informações de Contato</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">CPF/CNPJ:</span>
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ produtor.cpf_cnpj }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Email:</span>
                            <span>{{ produtor.email || 'Não informado' }}</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Propriedades</h3>
                    <ul v-if="produtor.propriedades && produtor.propriedades.length > 0" class="space-y-2">
                        <li v-for="propriedade in produtor.propriedades" :key="propriedade.id"
                            class="flex items-center gap-2">
                            <i class="pi pi-map-marker text-gray-500"></i>
                            <span>{{ propriedade.nome }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-500 italic">Nenhuma propriedade vinculada.</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Rebanhos</h3>
                    <ul v-if="produtor.rebanhos && produtor.rebanhos.length > 0" class="space-y-2">
                        <li v-for="rebanho in produtor.rebanhos" :key="rebanho.id" class="flex items-center gap-2">
                            <i class="pi pi-twitter text-gray-500"></i>
                            <span>{{ rebanho.especie }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-500 italic">Nenhum rebanho vinculado.</p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Unidades de Produção</h3>
                    <ul v-if="produtor.unidadesProducao && produtor.unidadesProducao.length > 0" class="space-y-2">
                        <li v-for="up in produtor.unidadesProducao" :key="up.id" class="flex items-center gap-2">
                            <i class="pi pi-twitter text-gray-500"></i>
                            <span>{{ up.nome_cultura }}</span>
                        </li>
                    </ul>
                    <p v-else class="text-gray-500 italic">Nenhuma unidade de produção vinculado.</p>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-end border-t pt-4">
                <Link :href="route('produtores.index')">
                <Button label="Voltar para a Lista" icon="pi pi-arrow-left" class="p-button-text" />
                </Link>
            </div>
        </template>
    </Card>
</template>
