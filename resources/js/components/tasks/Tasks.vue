<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';
import TaskTitle from '@/components/tasks/TaskTitle.vue';
import TaskDescription from '@/components/tasks/TaskDescription.vue';
import TaskStatus from '@/components/tasks/TaskStatus.vue';
import TaskPriority from '@/components/tasks/TaskPriority.vue';
import TaskActions from '@/components/tasks/TaskActions.vue';

const props = defineProps<{
    tasks: Task[];
}>();
</script>

<template>
    <div class="rounded-lg border bg-card p-6 shadow-sm">
        <div v-if="props.tasks.length" class="space-y-4">
            <div
                v-for="task in props.tasks"
                :key="task.id"
                class="flex items-start justify-between gap-4 border-b pb-3 last:border-0 last:pb-0"
            >
                <div class="flex-1 space-y-1">
                    <TaskTitle :task="task" />

                    <TaskDescription :task="task" />

                    <TaskStatus :task="task" />

                    <TaskPriority :task="task" />
                </div>

                <TaskActions class="flex items-center gap-2"/>
            </div>
        </div>

        <div v-else class="text-sm text-muted-foreground">
            No tasks for today.
        </div>
    </div>
</template>
