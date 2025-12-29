<script setup lang="ts">
import CreateTaskButton from '@/components/tasks/CreateTaskButton.vue';
import EmptyTasksMessage from '@/components/tasks/EmptyTasksMessage.vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import TasksSection from '@/components/tasks/TasksSection.vue';
import { useTaskDialog } from '@/composables/useTaskDialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { history } from '@/routes/tasks';
import { BreadcrumbItem } from '@/types';
import { LabelWithTasks } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';
import { formatDate } from '@/utils/date';
import { Head } from '@inertiajs/vue3';

const { dialogOpen, editingTask, editTask, createTask } = useTaskDialog();

const { tasksByDate } = defineProps<{
    tasksByDate: Record<string, Task[]>;
    labels: LabelWithTasks[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Upcoming', href: history().url },
];
</script>

<template>
    <Head title="Upcoming" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <EmptyTasksMessage
            v-if="Object.keys(tasksByDate).length === 0"
            title="No upcoming tasks"
        />

        <TasksSection
            v-for="(tasks, date) in tasksByDate"
            @edit-task="editTask"
            :key="date"
            :tasks="tasks"
            :title="formatDate(date)"
            :subtitle="'Your scheduled tasks for ' + date + '.'"
            :labels="labels"
        />
        <TaskFormDialog
            v-model:open="dialogOpen"
            :task="editingTask"
            :labels="labels"
        />
        <CreateTaskButton @create="createTask" />
    </AppLayout>
</template>
