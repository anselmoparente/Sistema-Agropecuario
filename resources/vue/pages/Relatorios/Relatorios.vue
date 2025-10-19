<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, Column, DataTable } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    propriedadesPorMunicipio: Array,
    animaisPorEspecie: Array,
    hectaresPorCultura: Array,
    produtores: Array,
});
</script>

<template>

    <Head title="Relatórios" />

    <div class="space-y-6">
        <Card class="shadow-lg">
            <template #title>
                <h2 class="text-xl font-bold text-gray-800">Exportar Relatórios</h2>
            </template>
            <template #content>
                <p class="text-gray-600 mb-4">
                    Gere relatórios completos em formato Excel ou PDF.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 pt-4 ">
                    <a :href="route('relatorios.export.propriedades.excel')">
                        <Button label="Exportar Propriedades (Excel)" icon="pi pi-file-excel"
                            class="p-button-success w-full sm:w-auto" />
                    </a>
                    <a :href="route('relatorios.export.rebanhos.pdf')">
                        <Button label="Relatório Geral de Rebanhos (PDF)" icon="pi pi-file-pdf"
                            class="p-button-danger w-full sm:w-auto" />
                    </a>
                </div>
            </template>
        </Card>

        <Card class="shadow-lg">
            <template #title>
                <h1 class="text-2xl font-bold text-gray-800">Relatórios Gerais</h1>
            </template>
            <template #content>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-4">
                    <div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-700">Total de Hectares por Cultura</h3>
                        <DataTable :value="hectaresPorCultura" stripedRows responsiveLayout="scroll">
                            <Column field="nome_cultura" header="Cultura"></Column>
                            <Column field="total" header="Total (ha)"></Column>
                        </DataTable>
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-700">Total de Animais por Espécie</h3>
                        <DataTable :value="animaisPorEspecie" stripedRows responsiveLayout="scroll">
                            <Column field="especie" header="Espécie"></Column>
                            <Column field="total" header="Total"></Column>
                        </DataTable>
                    </div>
                    <div class="lg:col-span-2">
                        <h3 class="font-semibold text-lg mb-2 text-gray-700">Total de Propriedades por Município</h3>
                        <DataTable :value="propriedadesPorMunicipio" stripedRows responsiveLayout="scroll">
                            <Column field="municipio" header="Município"></Column>
                            <Column field="total" header="Total"></Column>
                        </DataTable>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>
