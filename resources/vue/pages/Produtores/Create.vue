<script setup>
import { watch } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, DatePicker, InputMask, InputText } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const form = useForm({
    nome: '',
    cpf_cnpj: '',
    email: '',
    telefone: '',
    endereco: '',
    data_cadastro: null,
});

watch(() => form.cpf_cnpj, (value) => {
    if (!value) return;

    const digits = value.replace(/\D/g, '');

    if (digits.length > 11) {
        form.cpf_cnpj = digits.replace(
            /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
            '$1.$2.$3/$4-$5'
        );
    } else {
        form.cpf_cnpj = digits.replace(
            /^(\d{3})(\d{3})(\d{3})(\d{2})$/,
            '$1.$2.$3-$4'
        );
    }
});

const create = () => form.post(route('produtores.store'));
</script>

<template>

    <Head title="Criar Produtor"></Head>

    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Criar Novo Produtor</h1>
                <Link :href="route('produtores.index')">
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" />
                </Link>
            </div>
        </template>
        <template #content>
            <form @submit.prevent="create" class="mt-6">
                <p class="text-sm text-gray-600 mb-6">Campos marcados com <span class="text-red-500">*</span> são
                    obrigatórios.</p>
                <div class="p-fluid">
                    <div class="field mb-4">
                        <label for="nome" class="block text-gray-700 mb-2">Nome <span
                                class="text-red-500">*</span></label>
                        <InputText id="nome" v-model="form.nome" class="w-full"
                            :class="{ 'p-invalid': form.errors.nome }" placeholder="Digite o Nome" />
                        <small v-if="form.errors.nome" class="p-error">{{ form.errors.nome }}</small>
                    </div>

                    <div class="field mb-4">
                        <label for="cpf_cnpj" class="block text-gray-700 mb-2">CPF/CNPJ <span
                                class="text-red-500">*</span></label>
                        <InputText id="cpf_cnpj" v-model="form.cpf_cnpj" class="w-full"
                            :class="{ 'p-invalid': form.errors.cpf_cnpj }" placeholder="Digite o CPF ou CNPJ"
                            maxlength="18" />
                        <small v-if="form.errors.cpf_cnpj" class="p-error">{{ form.errors.cpf_cnpj }}</small>
                    </div>

                    <div class="field mb-4">
                        <label for="email" class="block text-gray-700 mb-2">Email</label>
                        <InputText id="email" v-model="form.email" class="w-full"
                            :class="{ 'p-invalid': form.errors.email }" placeholder="Digite o Email" />
                        <small v-if="form.errors.email" class="p-error">{{ form.errors.email }}</small>
                    </div>

                    <div class="field mb-4">
                        <label for="telefone" class="block text-gray-700 mb-2">Telefone</label>
                        <InputMask id="telefone" v-model="form.telefone" mask="(99) 99999-9999" class="w-full"
                            :class="{ 'p-invalid': form.errors.telefone }" placeholder="Digite o Telefone" />
                        <small v-if="form.errors.telefone" class="p-error">{{ form.errors.telefone }}</small>
                    </div>

                    <div class="field mb-4">
                        <label for="endereco" class="block text-gray-700 mb-2">Endereço</label>
                        <InputText id="endereco" v-model="form.endereco" class="w-full"
                            :class="{ 'p-invalid': form.errors.endereco }" placeholder="Digite o Endereço" />
                        <small v-if="form.errors.endereco" class="p-error">{{ form.errors.endereco }}</small>
                    </div>

                    <div class="field mb-4">
                        <label for="data_cadastro" class="block text-gray-700 mb-2">Data de Cadastro</label>
                        <DatePicker id="data_cadastro" v-model="form.data_cadastro" class="w-full"
                            :class="{ 'p-invalid': form.errors.data_cadastro }" dateFormat="dd/mm/yy" placeholder="Seleciona a Data"/>
                        <small v-if="form.errors.data_cadastro" class="p-error">{{ form.errors.data_cadastro }}</small>
                    </div>
                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Salvar Produtor" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>
