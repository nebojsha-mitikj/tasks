<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { history } from '@/routes/tasks';
import { AppPageProps, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import type { Task } from '@/types/tasks/Task';
import { computed } from 'vue';

const page = usePage<AppPageProps<{ tasks: Task[] }>>();
const tasks = computed(() => page.props.tasks ?? []);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Upcoming', href: history().url }
];
</script>

<template>
    <Head title="Upcoming" />
    <AppLayout :breadcrumbs="breadcrumbs">
        {{ tasks }}
    </AppLayout>
</template>

<style scoped></style>
