<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { getLabel } from '@/routes/labels';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
});


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Labels',
        href: getLabel(props.id).url,
    },
];
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">

    </AppLayout>
</template>

<style scoped></style>
