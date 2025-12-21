<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { history } from '@/routes/tasks';
import { Head } from '@inertiajs/vue3';
import type { Task } from '@/types/tasks/Task';
import { BreadcrumbItem } from '@/types';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import TasksSection from '@/components/tasks/TasksSection.vue';
import CreateTaskButton from '@/components/tasks/CreateTaskButton.vue';
import { useTaskDialog } from '@/composables/useTaskDialog';
import { format, parseISO } from 'date-fns';

const { dialogOpen, editingTask, editTask, createTask } = useTaskDialog();

const {tasksByDate} = defineProps<{
    tasksByDate: Record<string, Task[]>
}>()

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Upcoming', href: history().url }
];

const formatDate = (date: string): string => {
    return new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'short',
        day: 'numeric',
    });
}
</script>

<template>
    <Head title="Upcoming" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <TasksSection
            v-for="(tasks, date) in tasksByDate"
            @edit-task="editTask"
            :key="date"
            :tasks="tasks"
            :title="formatDate(date)"
            :subtitle="'Your scheduled tasks for ' + date + '.'"
        />
        <TaskFormDialog v-model:open="dialogOpen" :task="editingTask" />
        <CreateTaskButton @create="createTask"/>
    </AppLayout>
</template>
