<script setup>
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, DatePicker, InputText, InputNumber, Select } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    propriedades: Array,
    especies: Array,
});

const form = useForm({
    especie: null,
    quantidade: null,
    finalidade: '',
    data_atualizacao: null,
    propriedade_id: null,
});

const goBack = () => window.history.back();

const create = () => form.post(route('rebanhos.store'));
</script>

<template>

    <Head title="Criar Rebanho" />
    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Criar Novo Rebanho</h1>
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" @click="goBack" />
            </div>
        </template>
        <template #content>
            <form @submit.prevent="create" class="mt-6">
                <p class="text-sm text-gray-600 mb-6">Campos marcados com <span class="text-red-500">*</span> são
                    obrigatórios.</p>
                <div class="p-fluid space-y-4">

                    <div class="field">
                        <label for="propriedade_id" class="block text-gray-700 mb-2">Propriedade <span
                                class="text-red-500">*</span></label>
                        <Select v-model="form.propriedade_id" :options="propriedades" optionLabel="nome"
                            optionValue="id" placeholder="Selecione uma propriedade" class="w-full"
                            :class="{ 'p-invalid': form.errors.propriedade_id }" />
                        <small v-if="form.errors.propriedade_id" class="p-error">{{ form.errors.propriedade_id
                            }}</small>
                    </div>

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
                            placeholder="Selecione a data" />
                        <small v-if="form.errors.data_atualizacao" class="p-error">{{ form.errors.data_atualizacao
                            }}</small>
                    </div>

                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Salvar Rebanho" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>
