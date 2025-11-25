<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { getLabels } from '@/routes/labels';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Labels',
        href: getLabels().url,
    },
];
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>

<style scoped></style>
