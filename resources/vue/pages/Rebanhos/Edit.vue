<script setup>
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, DatePicker, InputText, InputNumber, Select } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    rebanho: Object,
    propriedades: Array,
    especies: Array,
});

const form = useForm({
    especie: props.rebanho.especie,
    quantidade: Number(props.rebanho.quantidade),
    finalidade: props.rebanho.finalidade,
    data_atualizacao: props.rebanho.data_atualizacao ? new Date(props.rebanho.data_atualizacao) : null,
    propriedade_id: props.rebanho.propriedade_id,
});

const goBack = () => window.history.back();

const update = () => form.put(route('rebanhos.update', props.rebanho.id));
</script>

<template>

    <Head title="Editar Rebanho" />
    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Editar Rebanho</h1>
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" @click="goBack" />
            </div>
        </template>
        <template #content>
            <form @submit.prevent="update" class="mt-6">
                <p class="text-sm text-gray-600 mb-6">Campos marcados com <span class="text-red-500">*</span> são
                    obrigatórios.</p>
                <div class="p-fluid space-y-4">
                    <div class="field">
                        <label for="especie" class="block text-gray-700 mb-2">Espécie <span
                                class="text-red-500">*</span></label>
                        <Select id="especie" v-model="form.especie" :options="especies"
                            placeholder="Selecione a espécie" :class="{ 'p-invalid': form.errors.especie }"
                            class="w-full" />
                        <small v-if="form.errors.especie" class="p-error">{{ form.errors.especie }}</small>
                    </div>

                    <div class="field">
                        <label for="quantidade" class="block text-gray-700 mb-2">Quantidade <span
                                class="text-red-500">*</span></label>
                        <InputNumber id="quantidade" v-model="form.quantidade" :min="0"
                            :class="{ 'p-invalid': form.errors.quantidade }" class="w-full"
                            placeholder="Digite a quantidade" />
                        <small v-if="form.errors.quantidade" class="p-error">{{ form.errors.quantidade }}</small>
                    </div>

                    <div class="field">
                        <label for="finalidade" class="block text-gray-700 mb-2">Finalidade</label>
                        <InputText id="finalidade" v-model="form.finalidade"
                            :class="{ 'p-invalid': form.errors.finalidade }" class="w-full"
                            placeholder="Ex: Corte, Leite, Reprodução" />
                        <small v-if="form.errors.finalidade" class="p-error">{{ form.errors.finalidade }}</small>
                    </div>

                    <div class="field">
                        <label for="data_atualizacao" class="block text-gray-700 mb-2">Data da Atualização</label>
                        <DatePicker id="data_atualizacao" v-model="form.data_atualizacao" dateFormat="dd/mm/yy"
                            :class="{ 'p-invalid': form.errors.data_atualizacao }" class="w-full"
                            placeholder="Selecione a Data" />
                        <small v-if="form.errors.data_atualizacao" class="p-error">{{ form.errors.data_atualizacao
                        }}</small>
                    </div>

                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Atualizar" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>
