<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { recurringTemplates } from '@/routes/recurring';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Recurring',
        href: recurringTemplates().url,
    },
];
</script>


<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>

<style scoped></style>
