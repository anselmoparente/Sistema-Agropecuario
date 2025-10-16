<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';

import logo from '@/assets/logo.png';

const form = useForm({
    email: '',
    password: '',
});
</script>

<template>

    <Head title="Login"></Head>

    <div class="flex items-center justify-center min-h-screen bg-green-100 dark:bg-green-900">
        <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-2xl shadow-lg dark:bg-gray-800">
            <div class="text-center">
                <img :src="logo" alt="Logo Agro" class="mx-auto w-24 h-24 rounded-full shadow-md" />
                <h2 class="text-3xl font-bold text-green-900 dark:text-green-200 mt-4">
                    Bem-vindo ao AgroSystem
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    Entre com suas credenciais do sistema.
                </p>
            </div>

            <form @submit.prevent="" class="space-y-6">
                <div class="flex flex-col gap-2">
                    <label for="email" class="font-semibold text-gray-700 dark:text-gray-200">E-mail</label>
                    <InputText id="email" v-model="form.email" type="email" placeholder="seuemail@email.com"
                        class="w-full" autofocus />
                </div>

                <div class="flex flex-col gap-2 w-full">
                    <label for="password" class="font-semibold text-gray-700 dark:text-gray-200">Senha</label>
                    <Password id="password1" v-model="form.password" placeholder="••••••••••••" :toggleMask="true"
                        :feedback="false" input-class="w-full!" />
                </div>

                <div>
                    <Button type="submit" label="Entrar" icon="pi pi-sign-in" class="w-full" />
                </div>
            </form>

            <p class="text-center text-gray-600 dark:text-gray-400">
                Não tem uma conta?
                <Link :href="route('register')" class="font-medium text-green-700 hover:text-green-600">
                Cadastre-se aqui
                </Link>
            </p>
        </div>
    </div>
</template>