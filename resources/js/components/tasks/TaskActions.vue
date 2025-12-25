<script setup lang="ts">
import EditTaskButton from '@/components/tasks/EditTaskButton.vue';
import TaskDeleteDialog from '@/components/tasks/TaskDeleteDialog.vue';
import UpdateTaskStatus from '@/components/tasks/UpdateTaskStatus.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import type { Task } from '@/types/tasks/Task';

const emit = defineEmits<{ (e: 'edit', task: Task): void }>();
const props = defineProps<{ task: Task }>();
const { isMatch: isTodayMatch } = usePageMatch('tasks/Today');
</script>

<template>
    <div>
        <UpdateTaskStatus v-if="isTodayMatch" :task="props.task" />

        <EditTaskButton @edit="emit('edit', $event)" :task="props.task" />

        <TaskDeleteDialog :task="props.task" />
    </div>
</template>
