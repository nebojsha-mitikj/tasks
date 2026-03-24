<script setup lang="ts">
import { destroy } from '@/actions/App/Http/Controllers/TaskController';
import DeleteDialogButton from '@/components/tasks/DeleteDialogButton.vue';
import EditButton from '@/components/tasks/EditButton.vue';
import TaskLabelPicker from '@/components/tasks/TaskLabelPicker.vue';
import UpdateTaskStatus from '@/components/tasks/UpdateTaskStatus.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import type { Label } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';

const emit = defineEmits<{
    (e: 'edit', task: Task): void;
}>();

const { task, labels } = defineProps<{
    task: Task;
    labels: Label[];
}>();

const { isMatch: isTodayMatch } = usePageMatch('tasks/Today');
</script>

<template>
    <div class="flex items-center gap-2">
        <UpdateTaskStatus v-if="isTodayMatch" :task="task" />

        <EditButton @edit="emit('edit', task)" tooltip="Edit task" />

        <TaskLabelPicker v-if="!task.is_virtual" :task="task" :labels="labels" />

        <DeleteDialogButton v-if="!task.is_virtual" :delete-url="destroy(task.id)" />
    </div>
</template>
