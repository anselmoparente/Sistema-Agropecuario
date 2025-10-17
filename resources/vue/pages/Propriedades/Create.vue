<script setup>
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, InputText, InputNumber, Select } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    produtores: Array,
});

const form = useForm({
    nome: '',
    municipio: '',
    uf: '',
    inscricao_estadual: '',
    area_total: null,
    produtor_id: null,
});

const ufs = [
    'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS',
    'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC',
    'SP', 'SE', 'TO'
];

const goBack = () => window.history.back();

const create = () => form.post(route('propriedades.store'));
</script>

<template>

    <Head title="Criar Propriedade" />
    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Criar Nova Propriedade</h1>
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" @click="goBack" />
            </div>
        </template>
        <template #content>
            <form @submit.prevent="create" class="mt-6">
                <p class="text-sm text-gray-600 mb-6">Campos marcados com <span class="text-red-500">*</span> são
                    obrigatórios.</p>
                <div class="p-fluid space-y-4">
                    <div class="field">
                        <label for="produtor_id" class="block text-gray-700 mb-2">Produtor <span
                                class="text-red-500">*</span></label>
                        <Select v-model="form.produtor_id" :options="produtores" optionLabel="nome" optionValue="id"
                            placeholder="Selecione um produtor" class="w-full"
                            :class="{ 'p-invalid': form.errors.produtor_id }" />
                        <small v-if="form.errors.produtor_id" class="p-error">{{ form.errors.produtor_id }}</small>
                    </div>
                    <div class="field">
                        <label for="nome" class="block text-gray-700 mb-2">Nome da Propriedade <span
                                class="text-red-500">*</span></label>
                        <InputText id="nome" v-model="form.nome" class="w-full" placeholder="Digite o Nome"
                            :class="{ 'p-invalid': form.errors.nome }" />
                        <small v-if="form.errors.nome" class="p-error">{{ form.errors.nome }}</small>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="field">
                            <label for="municipio" class="block text-gray-700 mb-2">Município <span
                                    class="text-red-500">*</span></label>
                            <InputText id="municipio" v-model="form.municipio"
                                :class="{ 'p-invalid': form.errors.municipio }" class="w-full"
                                placeholder="Digite o Município" />
                            <small v-if="form.errors.municipio" class="p-error">{{ form.errors.municipio }}</small>
                        </div>
                        <div class="field">
                            <label for="uf" class="block text-gray-700 mb-2">UF <span
                                    class="text-red-500">*</span></label>
                            <Select id="uf" v-model="form.uf" :options="ufs" placeholder="Selecione a UF"
                                :class="{ 'p-invalid': form.errors.uf }" class="w-full" />
                            <small v-if="form.errors.uf" class="p-error">{{ form.errors.uf }}</small>
                        </div>
                    </div>
                    <div class="field">
                        <label for="inscricao_estadual" class="block text-gray-700 mb-2">Inscrição Estadual</label>
                        <InputText id="inscricao_estadual" v-model="form.inscricao_estadual"
                            :class="{ 'p-invalid': form.errors.inscricao_estadual }" class="w-full"
                            placeholder="Digite o Inscrição Estadual" />
                        <small v-if="form.errors.inscricao_estadual" class="p-error">
                            {{ form.errors.inscricao_estadual }}
                        </small>
                    </div>
                    <div class="field">
                        <label for="area_total" class="block text-gray-700 mb-2">Área Total (ha) <span
                                class="text-red-500">*</span></label>
                        <InputNumber id="area_total" v-model="form.area_total" mode="decimal" :minFractionDigits="2"
                            :maxFractionDigits="2" :class="{ 'p-invalid': form.errors.area_total }" class="w-full"
                            placeholder="Digite a Área Total" />
                        <small v-if="form.errors.area_total" class="p-error">{{ form.errors.area_total }}</small>
                    </div>
                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Salvar Propriedade" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>
