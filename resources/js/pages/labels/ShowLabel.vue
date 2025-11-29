<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { show as getLabel } from '@/routes/labels';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    label: {
        type: Object,
        required: true,
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Labels',
        href: getLabel(props.label.id).url,
    },
];
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">
        {{label}}
    </AppLayout>
</template>

<style scoped></style>
