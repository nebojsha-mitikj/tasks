<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { index as getLabels } from '@/routes/labels';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import LabelHeader from '@/components/labels/LabelHeader.vue';
import LabelList from '@/components/labels/LabelList.vue';
import { Label } from '@/types/Label';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Labels', href: getLabels().url },
];

const { labels } = defineProps<{ labels: Label[] }>();
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
            <LabelHeader/>
            <LabelList :labels="labels"/>
        </div>
    </AppLayout>
</template>
