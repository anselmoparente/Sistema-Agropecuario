<script setup>
import { Head } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Card, Column, DataTable } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    propriedadesPorMunicipio: Array,
    animaisPorEspecie: Array,
    hectaresPorCultura: Array,
});
</script>

<template>

    <Head title="Relatórios" />

    <div class="space-y-8">
        <h1 class="text-3xl font-bold text-gray-800">Relatórios</h1>

        <Card class="shadow-lg">
            <template #title>
                <div class="flex items-center gap-3">
                    <i class="pi pi-map-marker text-xl text-blue-500"></i>
                    <h2 class="text-xl font-semibold text-gray-700">Total de Propriedades por Município</h2>
                </div>
            </template>
            <template #content>
                <DataTable :value="propriedadesPorMunicipio" stripedRows responsiveLayout="scroll"
                    class="p-datatable-sm">
                    <template #empty>Nenhum dado encontrado.</template>
                    <Column field="municipio" header="Município" sortable></Column>
                    <Column field="total" header="Total de Propriedades" sortable>
                        <template #body="{ data }">
                            {{ data.total }}
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Card class="shadow-lg">
            <template #title>
                <div class="flex items-center gap-3">
                    <i class="pi pi-prime text-xl text-green-500"></i>
                    <h2 class="text-xl font-semibold text-gray-700">Total de Animais por Espécie</h2>
                </div>
            </template>
            <template #content>
                <DataTable :value="animaisPorEspecie" stripedRows responsiveLayout="scroll" class="p-datatable-sm">
                    <template #empty>Nenhum dado encontrado.</template>
                    <Column field="especie" header="Espécie" sortable></Column>
                    <Column field="total" header="Quantidade Total" sortable>
                        <template #body="{ data }">
                            {{ data.total }}
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Card class="shadow-lg">
            <template #title>
                <div class="flex items-center gap-3">
                    <i class="pi pi-sitemap text-xl text-yellow-500"></i>
                    <h2 class="text-xl font-semibold text-gray-700">Total de Hectares por Cultura</h2>
                </div>
            </template>
            <template #content>
                <DataTable :value="hectaresPorCultura" stripedRows responsiveLayout="scroll" class="p-datatable-sm">
                    <template #empty>Nenhum dado encontrado.</template>
                    <Column field="nome_cultura" header="Cultura" sortable></Column>
                    <Column field="total" header="Área Total (ha)" sortable>
                        <template #body="{ data }">
                            {{ parseFloat(data.total).toFixed(2) }} ha
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>
    </div>
</template>
