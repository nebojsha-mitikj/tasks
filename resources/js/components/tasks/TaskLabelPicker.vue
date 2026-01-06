<script setup lang="ts">
import { updateLabels } from '@/actions/App/Http/Controllers/TaskController';
import PersistedLabelPicker from '@/components/labels/PersistedLabelPicker.vue';
import type { Label } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';

const { task, labels } = defineProps<{
    task: Task;
    labels: Label[];
}>();
</script>

<template>
    <PersistedLabelPicker
        :labels="labels"
        :selected="task.labels ?? []"
        :update-url="updateLabels(task.id)"
    />
</template>
