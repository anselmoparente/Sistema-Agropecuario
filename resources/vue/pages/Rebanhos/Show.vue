<script setup>
import { Head, Link } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, Divider } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    rebanho: Object,
});

const formatDate = (value) => {
    if (!value) return 'Não informada';
    const date = new Date(value);
    date.setDate(date.getDate() + 1);
    return date.toLocaleDateString('pt-BR');
};
</script>

<template>

    <Head title="Detalhes do Rebanho" />
    <Card class="shadow-lg max-w-4xl mx-auto">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                <div class="flex items-center gap-4">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-3 flex items-center justify-center">
                        <!-- Ícone pode ser melhorado -->
                        <i class="pi pi-server text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Rebanho de {{ rebanho.especie }}</h1>
                        <p class="text-sm text-gray-500">Propriedade: {{ rebanho.propriedade.nome }}</p>
                    </div>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <Link :href="route('rebanhos.edit', rebanho.id)" class="w-full sm:w-auto">
                    <Button label="Editar" icon="pi pi-pencil" class="p-button-outlined w-full" />
                    </Link>
                </div>
            </div>
        </template>
        <template #content>
            <Divider />
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 mt-4 text-gray-700">
                <div>
                    <h3 class="font-semibold text-lg text-gray-800 border-b pb-2 mb-4">Dados do Rebanho</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">ID:</span>
                            <span>{{ rebanho.id }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Espécie:</span>
                            <span class="font-semibold">{{ rebanho.especie }}</span>
                        </li>
                         <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Quantidade:</span>
                            <span>{{ rebanho.quantidade }}</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Finalidade:</span>
                            <span>{{ rebanho.finalidade || 'Não informada' }}</span>
                        </li>
                         <li class="flex justify-between items-center">
                            <span class="font-medium text-gray-500">Data da Atualização:</span>
                            <span>{{ formatDate(rebanho.data_atualizacao) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-end pt-4">
                <Link :href="route('rebanhos.index')">
                <Button label="Voltar para a Lista" icon="pi pi-arrow-left" class="p-button-text" />
                </Link>
            </div>
        </template>
    </Card>
</template>

