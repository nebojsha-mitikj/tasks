<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { history } from '@/routes/tasks';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import EmptyTasksMessage from '@/components/tasks/EmptyTasksMessage.vue';
import type { Task } from '@/types/tasks/Task';
import TasksSection from '@/components/tasks/TasksSection.vue';
import { formatDate } from '@/utils/date';
import { countCompleted } from '@/utils/taskCounts';

const breadcrumbs: BreadcrumbItem[] = [{
    title: 'History', href: history().url
}];

const {tasksByDate} = defineProps<{
    tasksByDate: Record<string, Task[]>
}>();


const subtitle = (tasks: Task[]): string => {
    const completedCount = countCompleted(tasks);
    const s = completedCount === 1 ? '' : 's';
    return `${completedCount} task${s} completed.`
};


</script>

<template>
    <Head title="History" />
    <AppLayout :breadcrumbs="breadcrumbs">

        <EmptyTasksMessage
            v-if="Object.keys(tasksByDate).length === 0"
            title="No completed tasks yet"
            subtitle="Tasks you complete will appear here."
        />

        <TasksSection
            v-for="(tasks, date) in tasksByDate"
            :key="date"
            :tasks="tasks"
            :title="formatDate(date)"
            :subtitle="subtitle(tasks)"
        />

    </AppLayout>
</template>
