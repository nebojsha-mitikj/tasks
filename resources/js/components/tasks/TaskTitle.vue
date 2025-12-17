<script setup lang="ts">
import { TaskStatus } from '@/enums/TaskStatus';
import type { Task } from '@/types/tasks/Task';

const props = defineProps<{
    task: Task
}>();
</script>

<template>
    <p
        class="text-sm font-medium"
        :class="{
            'text-muted-foreground line-through':
                props.task.status === TaskStatus.COMPLETED,
        }"
    >
        {{ props.task.title }}
    </p>
</template>
