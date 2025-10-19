<script setup>
import { ref, watch } from 'vue';
import { Head, router, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, ConfirmDialog, Column, DataTable, InputText, useConfirm, useToast } from 'primevue';
import debounce from 'lodash/debounce';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    produtores: Object,
    q: String,
});

const confirm = useConfirm();
const toast = useToast();
const search = ref(props.q);

const form = useForm({});

const performSearch = debounce((value) => {
    router.get(route('produtores.index'), { q: value }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch(search, (value) => {
    performSearch(value);
});

const confirmDelete = (produtor) => {
    confirm.require({
        message: `Tem certeza que deseja excluir "${produtor.nome}"? Esta ação não pode ser desfeita.`,
        header: 'Confirmação de Exclusão',
        icon: 'pi pi-exclamation-triangle',
        acceptLabel: 'Sim, excluir',
        rejectLabel: 'Cancelar',
        acceptClass: 'p-button-danger',
        accept: () => {
            form.delete(route('produtores.destroy', produtor.id), {
                onSuccess: () => {
                    toast.add({ severity: 'success', summary: 'Sucesso', detail: 'Produtor removido.', life: 3000 });
                },
                onError: (errors) => {
                    toast.add({ severity: 'error', summary: 'Erro', detail: errors.geral || 'Não foi possível remover o produtor.', life: 3000 });
                }
            });
        },
    });
};
</script>

<template>

    <Head title="Produtores"></Head>

    <ConfirmDialog></ConfirmDialog>
    <Card class="shadow-lg">
        <template #title>
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Listagem de Produtores</h1>
                <Link :href="route('produtores.create')">
                <Button label="Novo Produtor" icon="pi pi-plus" />
                </Link>
            </div>
        </template>
        <template #content>
            <div class="flex justify-end mb-4">
                <InputText v-model="search" placeholder="Buscar por nome, CPF/CNPJ..." class="w-full" />
            </div>

            <DataTable :value="produtores.data" paginator :rows="produtores.per_page" stripedRows
                responsiveLayout="scroll" :totalRecords="produtores.total" class="p-datatable-customers" :pt="{
                    paginator: {
                        root: { class: 'border-t' }
                    }
                }">
                <template #empty>Nenhum produtor encontrado.</template>

                <Column field="nome" header="Nome" sortable style="min-width: 14rem"></Column>
                <Column field="cpf_cnpj" header="CPF/CNPJ" style="min-width: 10rem"></Column>
                <Column field="propriedades_count" header="Propriedades" style="min-width: 6rem" class="text-center">
                </Column>
                <Column field="rebanhos_count" header="Rebanhos" style="min-width: 6rem" class="text-center"></Column>
                <Column field="unidades_producao_count" header="Unidades de Produção" style="min-width: 6rem"
                    class="text-center">
                </Column>

                <Column header="Ações" headerStyle="width: 10rem; text-align: center"
                    bodyStyle="text-align: center; overflow: visible">
                    <template #body="{ data }">
                        <div class="flex justify-center gap-2">
                            <Link :href="route('produtores.show', data.id)">
                            <Button icon="pi pi-eye" class="p-button-rounded p-button-info p-button-text" />
                            </Link>
                            <Link :href="route('produtores.edit', data.id)">
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