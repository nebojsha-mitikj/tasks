<script setup lang="ts">
import { destroy } from '@/actions/App/Http/Controllers/RecurringTaskTemplateController';
import RecurringTemplateLabelPicker from '@/components/recurring-task-templates/RecurringTemplateLabelPicker.vue';
import RecurringTemplateToggle from '@/components/recurring-task-templates/RecurringTemplateToggle.vue';
import DeleteDialogButton from '@/components/tasks/DeleteDialogButton.vue';
import EditButton from '@/components/tasks/EditButton.vue';
import type { Label } from '@/types/labels/Label';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';

const emit = defineEmits<{
    (e: 'edit', template: RecurringTaskTemplate): void;
}>();

const { template, labels } = defineProps<{
    template: RecurringTaskTemplate;
    labels: Label[];
}>();
</script>

<template>
    <div class="flex items-center gap-2">
        <RecurringTemplateToggle :template="template" />

        <EditButton
            @edit="emit('edit', template)"
            tooltip="Edit task template"
        />

        <RecurringTemplateLabelPicker :template="template" :labels="labels" />

        <DeleteDialogButton :delete-url="destroy(template.id)" />
    </div>
</template>
