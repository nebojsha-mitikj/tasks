<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';

const props = defineProps<{
    task: Task;
}>();
</script>

<template>
    <p v-if="props.task.description" class="text-xs text-muted-foreground">
        {{ props.task.description }}
    </p>
</template>
