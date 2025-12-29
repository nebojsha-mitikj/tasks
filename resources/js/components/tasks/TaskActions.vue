<script setup lang="ts">
import EditTaskButton from '@/components/tasks/EditTaskButton.vue';
import TaskDeleteDialog from '@/components/tasks/TaskDeleteDialog.vue';
import TaskLabel from '@/components/tasks/TaskLabel.vue';
import UpdateTaskStatus from '@/components/tasks/UpdateTaskStatus.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import type { Label } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';

const emit = defineEmits<{
    (e: 'edit', task: Task): void;
}>();

const props = defineProps<{
    task: Task;
    labels: Label[];
}>();

const { isMatch: isTodayMatch } = usePageMatch('tasks/Today');
</script>

<template>
    <div>
        <UpdateTaskStatus v-if="isTodayMatch" :task="props.task" />

        <EditTaskButton @edit="emit('edit', $event)" :task="props.task" />

        <TaskLabel :task="task" :labels="labels" />

        <TaskDeleteDialog :task="props.task" />
    </div>
</template>
