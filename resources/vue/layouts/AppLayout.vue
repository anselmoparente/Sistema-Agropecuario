<script setup>
import Toast from 'primevue/toast';

defineOptions({ inheritAttrs: false });
</script>

<template>
    <Toast position="top-right" />

    <main>
        <slot></slot>
    </main>
</template>