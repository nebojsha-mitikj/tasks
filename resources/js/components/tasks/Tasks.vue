<script setup lang="ts">
import TaskActions from '@/components/tasks/TaskActions.vue';
import TaskDescription from '@/components/tasks/TaskDescription.vue';
import TaskPriority from '@/components/tasks/TaskPriority.vue';
import TaskStatus from '@/components/tasks/TaskStatus.vue';
import TaskTitle from '@/components/tasks/TaskTitle.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import type { Task } from '@/types/tasks/Task';

const props = defineProps<{
    tasks: Task[];
}>();

const emit = defineEmits<{
    (e: 'edit', task: Task): void;
}>();

const { isMatch: isTodayMatch } = usePageMatch('tasks/Today');
const { isMatch: isHistoryMatch } = usePageMatch('tasks/History');
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

                    <template v-if="!isHistoryMatch">
                        <TaskStatus v-if="isTodayMatch" :task="task" />
                        <TaskPriority :task="task" />
                    </template>
                </div>

                <TaskActions
                    v-if="!isHistoryMatch"
                    :task="task"
                    @edit="emit('edit', $event)"
                    class="flex items-center gap-2"
                />
            </div>
        </div>

        <div v-else class="text-sm text-muted-foreground">
            No tasks for today.
        </div>
    </div>
</template>
