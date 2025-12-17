<script setup lang="ts">
import { statusClass, statusLabel } from '@/utils/tasks';
import type { Task } from '@/types/tasks/Task';

const props = defineProps<{
    task: Task
}>();
</script>

<template>
    <p class="text-[11px] text-muted-foreground">
        Status:
        <span
            class="font-bold"
            :class="statusClass(props.task.status)"
        >{{ statusLabel(props.task.status) }}</span
        >
    </p>
</template>

<style scoped></style>
