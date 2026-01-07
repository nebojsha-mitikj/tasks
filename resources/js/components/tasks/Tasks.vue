<script setup lang="ts">
import LabelBadgeList from '@/components/labels/LabelBadgeList.vue';
import TaskListCard from '@/components/list/TaskListCard.vue';
import DescriptionText from '@/components/tasks/DescriptionText.vue';
import PriorityText from '@/components/tasks/PriorityText.vue';
import TaskActions from '@/components/tasks/TaskActions.vue';
import TaskStatus from '@/components/tasks/TaskStatus.vue';
import TaskTitle from '@/components/tasks/TaskTitle.vue';
import { usePageMatch } from '@/composables/usePageMatch';
import { TaskStatus as TaskStatusEnum } from '@/enums/TaskStatus';
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

                <DescriptionText :text="task.description" />

                <template v-if="!isHistoryMatch">
                    <TaskStatus v-if="isTodayMatch" :task="task" />
                    <PriorityText
                        v-if="task.status !== TaskStatusEnum.COMPLETED"
                        :priority="task.priority"
                    />
                </template>
                <LabelBadgeList :labels="task.labels" />
            </div>

            <TaskActions
                v-if="!isHistoryMatch"
                :task="task"
                :labels="labels"
                @edit="emit('edit', $event)"
            />
        </template>
    </TaskListCard>
</template>
