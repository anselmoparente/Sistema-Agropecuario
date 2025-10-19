<script setup>
import { reactive, watch } from 'vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, ConfirmDialog, Column, DataTable, Select, useConfirm, useToast } from 'primevue';
import debounce from 'lodash/debounce';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    rebanhos: Object,
    filters: Object,
    especies: Array,
    propriedades: Array,
    produtores: Array,
});

const confirm = useConfirm();
const toast = useToast();
const form = useForm({});

const filtersForm = reactive({
    especie: props.filters.especie,
    propriedade_id: props.filters.propriedade_id,
    produtor_id: props.filters.produtor_id,
});

const performSearch = debounce(() => {
    router.get(route('rebanhos.index'), filtersForm, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
}, 300);

watch(filtersForm, () => {
    performSearch();
}, { deep: true });

const formatDate = (value) => {
    if (!value) return '';
    const date = new Date(value);
    date.setDate(date.getDate() + 1);
    return date.toLocaleDateString('pt-BR');
};

const confirmDelete = (rebanho) => {
    confirm.require({
        message: `Tem certeza que deseja excluir o rebanho de ${rebanho.especie}?`,
        header: 'Confirmação de Exclusão',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sim, excluir',
        rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => {
            form.delete(route('rebanhos.destroy', rebanho.id), {
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Rebanho removido.', life: 3000 });
                },
                onError: (errors) => {
                    toast.add({ severity: 'error', summary: 'Erro', detail: errors.geral || 'Não foi possível remover.', life: 3000 });
                }
            });
        },
    });
};
</script>

<template>

    <Head title="Rebanhos" />

    <ConfirmDialog></ConfirmDialog>
    <Card class="shadow-lg">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Listagem de Rebanhos</h1>
                <Link :href="route('rebanhos.create')">
                <Button label="Novo Rebanho" icon="pi pi-plus" />
                </Link>
            </div>
        </template>
        <template #content>
            <div class="flex flex-col sm:flex-row justify-end items-center gap-2 mb-4">
                <Select v-model="filtersForm.especie" :options="especies" placeholder="Filtrar por Espécie" showClear
                    class="w-full sm:w-60" />
                <Select v-model="filtersForm.propriedade_id" :options="propriedades" optionLabel="nome" optionValue="id"
                    placeholder="Filtrar por Propriedade" showClear class="w-full sm:w-60" />
                <Select v-model="filtersForm.produtor_id" :options="produtores" optionLabel="nome" optionValue="id"
                    placeholder="Filtrar por Produtor" showClear class="w-full sm:w-60" />
            </div>

            <DataTable :value="rebanhos.data" paginator :rows="rebanhos.per_page" stripedRows responsiveLayout="scroll"
                :totalRecords="rebanhos.total" class="p-datatable-customers">
                <template #empty>Nenhum rebanho encontrado.</template>

                <Column field="especie" header="Espécie" sortable></Column>
                <Column field="quantidade" header="Quantidade" sortable></Column>
                <Column field="propriedade.nome" header="Propriedade" sortable></Column>
                <Column field="data_atualizacao" header="Data da Atualização" sortable>
                    <template #body="{ data }">
                        {{ formatDate(data.data_atualizacao) }}
                    </template>
                </Column>

                <Column header="Ações" headerStyle="width: 10rem; text-align: center"
                    bodyStyle="text-align: center; overflow: visible">
                    <template #body="{ data }">
                        <div class="flex justify-center gap-2">
                            <Link :href="route('rebanhos.show', data.id)">
                            <Button icon="pi pi-eye" class="p-button-rounded p-button-info p-button-text" />
                            </Link>
                            <Link :href="route('rebanhos.edit', data.id)">
                            <Button icon="pi pi-pencil" class="p-button-rounded p-button-success p-button-text" />
                            </Link>
                            <Button @click="confirmDelete(data)" icon="pi pi-trash"
                                class="p-button-rounded p-button-danger p-button-text" />
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>
</template>
