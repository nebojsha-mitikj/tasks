<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import type { Task } from '@/types/tasks/Task';
const { task } = defineProps<{ task: Task }>();
</script>

<template>
    <p v-if="task.labels.length > 0" class="text-[11px] text-muted-foreground">
        Labels:
        <Badge
            variant="secondary"
            v-for="label in task.labels"
            :key="label.id"
            class="ml-2 font-bold"
        >
            {{ label.name }}
        </Badge>
    </p>
</template>
