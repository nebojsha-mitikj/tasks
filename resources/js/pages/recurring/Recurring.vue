<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { recurringTemplates } from '@/routes/recurring';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Recurring',
        href: recurringTemplates().url,
    },
];
</script>

<template>
    <Head title="Recurring" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight">
                            Recurring tasks
                        </h1>
                        <p class="text-sm text-muted-foreground">
                            <span
                                >Tasks that repeat on a schedule so you never
                                forget.</span
                            >
                        </p>
                    </div>
                </div>
                <TooltipButton :icon="Plus" tooltip="Add recurring task" />
            </div>
        </div>
    </AppLayout>
</template>
