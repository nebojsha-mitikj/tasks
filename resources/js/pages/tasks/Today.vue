<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { today } from '@/routes/tasks';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Today',
        href: today().url,
    },
];
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>

<style scoped></style>
