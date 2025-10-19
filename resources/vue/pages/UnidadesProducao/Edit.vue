<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, InputText, InputNumber, Select } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    up: Object,
    culturas: Array,
});

const form = useForm({
    nome_cultura: props.up.nome_cultura,
    area_total_ha: Number(props.up.area_total_ha),
    coordenadas_geograficas: props.up.coordenadas_geograficas,
});

const goBack = () => window.history.back();

const update = () => form.put(route('unidades-producao.update', props.up.id));
</script>

<template>

    <Head title="Editar Unidade de Produção" />
    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Editar Unidade de Produção</h1>
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" @click="goBack" />
            </div>
        </template>
        <template #content>
            <form @submit.prevent="update" class="mt-6">
                <p class="text-sm text-gray-600 mb-6">Campos marcados com <span class="text-red-500">*</span> são
                    obrigatórios.</p>
                <div class="p-fluid space-y-4">

                    <div class="field">
                        <label for="nome_cultura" class="block text-gray-700 mb-2">Cultura <span
                                class="text-red-500">*</span></label>
                        <Select id="nome_cultura" v-model="form.nome_cultura" :options="culturas"
                            placeholder="Selecione a cultura" :class="{ 'p-invalid': form.errors.nome_cultura }"
                            class="w-full" />
                        <small v-if="form.errors.nome_cultura" class="p-error">{{ form.errors.nome_cultura }}</small>
                    </div>

                    <div class="field">
                        <label for="area_total_ha" class="block text-gray-700 mb-2">Área Total (ha)</label>
                        <InputNumber id="area_total_ha" v-model="form.area_total_ha" mode="decimal"
                            :minFractionDigits="2" :maxFractionDigits="2"
                            :class="{ 'p-invalid': form.errors.area_total_ha }" class="w-full" />
                        <small v-if="form.errors.area_total_ha" class="p-error">{{ form.errors.area_total_ha }}</small>
                    </div>

                    <div class="field">
                        <label for="coordenadas_geograficas" class="block text-gray-700 mb-2">Coordenadas
                            Geográficas</label>
                        <InputText id="coordenadas_geograficas" v-model="form.coordenadas_geograficas"
                            :class="{ 'p-invalid': form.errors.coordenadas_geograficas }" class="w-full" />
                        <small v-if="form.errors.coordenadas_geograficas" class="p-error">{{
                            form.errors.coordenadas_geograficas }}</small>
                    </div>

                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Atualizar Unidade" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>
