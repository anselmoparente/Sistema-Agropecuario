<script setup>
import { watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Button, Card, DatePicker, InputMask, InputText } from 'primevue';

defineOptions({ layout: AuthenticatedLayout });

const props = defineProps({
    produtor: Object,
});

const parseDate = (dateString) => {
    if (!dateString) return null;
    const [year, month, day] = dateString.split('T')[0].split('-');

    return new Date(year, month - 1, day);
};

const form = useForm({
    ...props.produtor,
    data_cadastro: parseDate(props.produtor.data_cadastro),
});

watch(() => form.cpf_cnpj, (newValue, oldValue) => {
    if (!newValue) return;

    const digits = newValue.replace(/\D/g, '');

    if (digits.length > 14) {
        form.cpf_cnpj = oldValue;
        return;
    }

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

const goBack = () => window.history.back();

const update = () => form.put(route('produtores.update', props.produtor.id));
</script>

<template>

    <Head title="Editar Produtor"></Head>

    <Card class="shadow-lg max-w-3xl mx-auto">
        <template #title>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Editar Produtor</h1>
                <Button label="Voltar" icon="pi pi-arrow-left" class="p-button-text" @click="goBack"/>
            </div>
        </template>
        <template #content>
            <form @submit.prevent="update" class="mt-6">
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
                            :class="{ 'p-invalid': form.errors.telefone }" maxlength="15"
                            placeholder="Digite o Telefone" />
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
                            :class="{ 'p-invalid': form.errors.data_cadastro }" dateFormat="dd/mm/yy"
                            placeholder="Seleciona a Data" />
                        <small v-if="form.errors.data_cadastro" class="p-error">{{ form.errors.data_cadastro }}</small>
                    </div>
                </div>
                <div class="flex justify-end mt-8 pt-4">
                    <Button type="submit" label="Atualizar Produtor" :loading="form.processing" icon="pi pi-check" />
                </div>
            </form>
        </template>
    </Card>
</template>