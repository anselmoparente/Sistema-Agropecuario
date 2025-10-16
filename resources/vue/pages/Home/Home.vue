<script setup>
import { router } from '@inertiajs/vue3';
import { Button, useToast } from 'primevue';

import AppLayout from '@/Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

const toast = useToast();

const logout = () => router.post(route('logout'), {
    onError: () => {
        toast.add({
            severity: 'error',
            summary: 'Erro',
            detail: 'Não foi possível completar a ação. Tente novamente.',
            life: 3000
        });
    }
});
</script>

<template>
    <Button label="Deslogar" icon="pi pi-sign-out" @click="logout"></Button>
</template>

<style scoped></style>