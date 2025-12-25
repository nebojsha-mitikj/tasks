<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import TaskSection from '@/components/tasks/TasksSection.vue';
import type { BreadcrumbItem } from '@/types';
import type { LabelWithTasks } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import PageTitle from '@/components/tasks/PageTitle.vue';
import { useTaskDialog } from '@/composables/useTaskDialog';
import { formatDate, toDate } from '@/utils/date';
const { dialogOpen, editingTask, editTask } = useTaskDialog();

const { label } = defineProps<{ label: LabelWithTasks }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Labels', href: '/labels' },
    { title: label.name, href: `/labels/${label.id}` }
];

const tasksByDate = computed<Record<string, Task[]>>(() => {
    return label.tasks.reduce<Record<string, Task[]>>((accumulator, task) => {
        const key = toDate(task.date);
        (accumulator[key] ??= []).push(task);
        return accumulator;
    }, {});
});

const title = computed(() => `${label.name}`);

const subtitle = computed(() =>
    label.tasks.length > 0
        ? 'Tasks for this label.'
        : 'No upcoming tasks for this label.',
);
</script>

<template>
    <Head :title="label.name" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="mx-auto mt-10 w-full max-w-4xl space-y-6">
            <PageTitle :title="title" :subtitle="subtitle"/>
        </div>

        <template v-if="label.tasks.length">
            <div class="space-y-8">
                <TaskSection
                    v-for="(tasks, date) in tasksByDate"
                    :key="date"
                    :tasks="tasks"
                    :title="formatDate(date)"
                    @editTask="editTask"
                />
            </div>
        </template>

        <TaskFormDialog v-model:open="dialogOpen" :task="editingTask" />
    </AppLayout>
</template>
