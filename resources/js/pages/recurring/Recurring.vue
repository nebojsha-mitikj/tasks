<script setup lang="ts">
import RecurringTaskTemplates from '@/components/recurring-task-templates/RecurringTaskTemplates.vue';
import RecurringTemplateFormDialog from '@/components/recurring-task-templates/RecurringTemplateFormDialog.vue';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { useRecurringTemplateDialog } from '@/composables/useRecurringTemplateDialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { index } from '@/routes/recurring';
import { type BreadcrumbItem } from '@/types';
import type { Label } from '@/types/labels/Label';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { Head } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';

const { dialogOpen, editingTemplate, editTemplate, createTemplate } =
    useRecurringTemplateDialog();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Recurring', href: index().url },
];

const { labels, templates } = defineProps<{
    labels: Label[];
    templates: RecurringTaskTemplate[];
}>();
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
                            <span>
                                Tasks that repeat on a schedule so you never
                                forget.
                            </span>
                        </p>
                    </div>
                </div>
                <TooltipButton
                    @click="createTemplate"
                    :icon="Plus"
                    tooltip="Add recurring task"
                />
            </div>

            <RecurringTaskTemplates
                :templates="templates"
                :labels="labels"
                @edit="editTemplate"
            />
        </div>

        <RecurringTemplateFormDialog
            v-model:open="dialogOpen"
            :template="editingTemplate"
            :labels="labels"
        />
    </AppLayout>
</template>
