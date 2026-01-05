<script setup lang="ts">
import TaskListCard from '@/components/list/TaskListCard.vue';
import TaskActions from '@/components/tasks/TaskActions.vue';
import TaskDescription from '@/components/tasks/TaskDescription.vue';
import TaskLabels from '@/components/tasks/TaskLabels.vue';
import TaskPriority from '@/components/tasks/TaskPriority.vue';
import TaskStatus from '@/components/tasks/TaskStatus.vue';
import TaskTitle from '@/components/tasks/TaskTitle.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import type { Label } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';

const { tasks, labels } = defineProps<{
    tasks: Task[];
    labels: Label[];
}>();

const emit = defineEmits<{
    (e: 'edit', task: Task): void;
}>();

const { isMatch: isTodayMatch } = usePageMatch('tasks/Today');
const { isMatch: isHistoryMatch } = usePageMatch('tasks/History');
</script>

<template>
    <TaskListCard :items="tasks" empty-text="No tasks for today.">
        <template #row="{ item: task }">
            <div class="flex-1 space-y-1">
                <TaskTitle :task="task" />

                <TaskDescription :task="task" />

                <template v-if="!isHistoryMatch">
                    <TaskStatus v-if="isTodayMatch" :task="task" />
                    <TaskPriority :task="task" />
                    <TaskLabels :task="task" />
                </template>
            </div>

            <TaskActions
                v-if="!isHistoryMatch"
                :task="task"
                :labels="labels"
                @edit="emit('edit', $event)"
                class="flex items-center gap-2"
            />
        </template>
    </TaskListCard>
</template>
