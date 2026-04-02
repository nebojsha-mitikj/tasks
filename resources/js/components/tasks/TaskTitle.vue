<script setup lang="ts">
import { TaskStatus } from '@/enums/TaskStatus';
import type { Task } from '@/types/tasks/Task';

const props = defineProps<{
    task: Task;
}>();
</script>

<template>
    <p
        class="text-[15px] font-medium leading-snug"
        :class="props.task.status === TaskStatus.COMPLETED
            ? 'text-[#bbb] line-through dark:text-[#555]'
            : 'text-[#111] dark:text-white'"
    >
        {{ props.task.title }}
    </p>
</template>
