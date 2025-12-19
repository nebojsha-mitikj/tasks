<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { history } from '@/routes/tasks';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'History',
        href: history().url,
    },
];
</script>

<template>
    <Head title="History" />
    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>

<style scoped></style>
