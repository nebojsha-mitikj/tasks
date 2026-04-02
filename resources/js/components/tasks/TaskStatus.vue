<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';
import { TaskStatus } from '@/enums/TaskStatus';

const props = defineProps<{
    task: Task;
}>();

const badgeClass = {
    [TaskStatus.TO_DO]: 'bg-sky-50 text-sky-700 border-sky-200 dark:bg-sky-950/40 dark:text-sky-400 dark:border-sky-800/40',
    [TaskStatus.IN_PROGRESS]: 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-950/40 dark:text-amber-400 dark:border-amber-800/40',
    [TaskStatus.COMPLETED]: 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40',
} as const;

const badgeLabel = {
    [TaskStatus.TO_DO]: 'To do',
    [TaskStatus.IN_PROGRESS]: 'In progress',
    [TaskStatus.COMPLETED]: 'Completed',
} as const;
</script>

<template>
    <span
        class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-medium"
        :class="badgeClass[props.task.status]"
    >
        {{ badgeLabel[props.task.status] }}
    </span>
</template>
