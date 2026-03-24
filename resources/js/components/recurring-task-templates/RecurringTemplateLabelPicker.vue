<script setup lang="ts">
import { updateLabels } from '@/actions/App/Http/Controllers/RecurringTaskTemplateController';
import PersistedLabelPicker from '@/components/labels/PersistedLabelPicker.vue';
import type { Label } from '@/types/labels/Label';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';

const { template, labels } = defineProps<{
    template: RecurringTaskTemplate;
    labels: Label[];
}>();
</script>

<template>
    <PersistedLabelPicker
        :labels="labels"
        :selected="template.labels"
        :update-url="updateLabels(template.id)"
    />
</template>
