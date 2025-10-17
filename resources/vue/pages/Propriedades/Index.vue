<script setup>
import { ref, watch } from 'vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, ConfirmDialog, Column, DataTable, InputText, useConfirm, useToast } from 'primevue';
import debounce from 'lodash/debounce';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    propriedades: Object,
    filters: Object,
});

const confirm = useConfirm();
const toast = useToast();
const search = ref(props.filters.q);

const form = useForm({});

const performSearch = debounce((value) => {
    router.get(route('propriedades.index'), { q: value }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch(search, (value) => {
    performSearch(value);
});

const confirmDelete = (propriedade) => {
    confirm.require({
        message: `Tem certeza que deseja excluir "${propriedade.nome}"?`,
        header: 'Confirmação de Exclusão',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sim, excluir',
        rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => {
            form.delete(route('propriedades.destroy', propriedade.id), {
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Propriedade removida.', life: 3000 });
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

    <Head title="Propriedades"></Head>

    <ConfirmDialog></ConfirmDialog>
    <Card class="shadow-lg">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Listagem de Propriedades</h1>
                <Link :href="route('propriedades.create')">
                <Button label="Novo Propriedade" icon="pi pi-plus" />
                </Link>
            </div>
        </template>
        <template #content>
            <div class="flex justify-end mb-4">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="search" placeholder="Buscar por nome..." class="w-full sm:w-auto" />
                </span>
            </div>

            <DataTable :value="propriedades.data" paginator :rows="propriedades.per_page" stripedRows
                responsiveLayout="scroll" :totalRecords="propriedades.total" class="p-datatable-customers">
                <template #empty>Nenhuma propriedade encontrada.</template>

                <Column field="nome" header="Nome" sortable></Column>
                <Column field="produtor.nome" header="Produtor" sortable></Column>
                <Column field="municipio" header="Município" sortable></Column>
                <Column field="uf" header="UF" sortable></Column>
                <Column header="Ações" headerStyle="width: 10rem; text-align: center"
                    bodyStyle="text-align: center; overflow: visible">
                    <template #body="{ data }">
                        <div class="flex justify-center gap-2">
                            <Link :href="route('propriedades.show', data.id)">
                            <Button icon="pi pi-eye" class="p-button-rounded p-button-info p-button-text" />
                            </Link>
                            <Link :href="route('propriedades.edit', data.id)">
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