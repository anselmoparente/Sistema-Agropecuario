<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button, Card, FloatLabel, InputText, Password, useToast } from 'primevue';

import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const register = () => form.post(route('register'), {
    onError: (errors) => {
        const firstError = Object.values(errors)[0];
        toast.add({
            severity: 'error',
            summary: 'Erro no Cadastro',
            detail: firstError,
            life: 3000
        });
    }
});
</script>

<template>

    <Head title="Registrar"></Head>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <Card class="w-full max-w-md p-4">
            <template #title>
                <h2 class="text-2xl font-bold text-center">Criar Conta</h2>
            </template>
            <template #content>
                <form @submit.prevent="register" class="mt-8">
                    <div class="flex flex-col gap-8">
                        <FloatLabel>
                            <InputText id="name" v-model="form.name" class="w-full" input-class="w-full"
                                :invalid="form.errors.name" />
                            <label for="name">Nome</label>
                        </FloatLabel>
                        <small v-if="form.errors.name" class="text-red-500 -mt-6">{{ form.errors.name }}</small>

                        <FloatLabel>
                            <InputText id="email" v-model="form.email" class="w-full" input-class="w-full"
                                :invalid="form.errors.email" />
                            <label for="email">Email</label>
                        </FloatLabel>
                        <small v-if="form.errors.email" class="text-red-500 -mt-6">{{ form.errors.email }}</small>

                        <FloatLabel>
                            <Password id="password" v-model="form.password" class="w-full" input-class="w-full"
                                :feedback="false" toggleMask :invalid="form.errors.password" />
                            <label for="password">Senha</label>
                        </FloatLabel>
                        <small v-if="form.errors.password" class="text-red-500 -mt-6">{{ form.errors.password }}</small>

                        <FloatLabel>
                            <Password id="password_confirmation" v-model="form.password_confirmation" class="w-full"
                                input-class="w-full" :feedback="false" toggleMask
                                :invalid="form.errors.password_confirmation" />
                            <label for="password_confirmation">Confirmar Senha</label>
                        </FloatLabel>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <Link :href="route('login')" class="text-sm font-medium text-primary-600 hover:underline">
                        Já possui uma conta?
                        </Link>

                        <Button type="submit" label="Registrar" :loading="form.processing" />
                    </div>
                </form>
            </template>
        </Card>
    </div>
</template>