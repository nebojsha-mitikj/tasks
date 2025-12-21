<script setup lang="ts">
import { TaskStatus } from '@/enums/TaskStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { today } from '@/routes/tasks';
import { type Task } from '@/types/tasks/Task';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import CreateTaskButton from '@/components/tasks/CreateTaskButton.vue';
import TasksSection from '@/components/tasks/TasksSection.vue';
import { useTaskDialog } from '@/composables/useTaskDialog';
import { BreadcrumbItem } from '@/types';
import EmptyTasksMessage from '@/components/tasks/EmptyTasksMessage.vue';

const { dialogOpen, editingTask, editTask, createTask } = useTaskDialog();
const { tasks } = defineProps<{ tasks: Task[]; }>();
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Today', href: today().url }];

const completeCount = computed(
    () =>
        tasks.filter((task) => task.status === TaskStatus.COMPLETED)
            .length,
);

const title = computed(() =>
    tasks.length > 0
        ? `Today - ${completeCount.value}/${tasks.length} complete`
        : 'Today',
);
</script>

<template>
    <Head title="Today" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <TasksSection
            v-if="tasks.length > 0"
            @edit-task="editTask"
            :tasks="tasks"
            :title="title"
            subtitle="Your scheduled tasks for today."
        />

        <EmptyTasksMessage v-else title="No tasks for today" />

        <TaskFormDialog
            v-model:open="dialogOpen"
            :task="editingTask"
        />
        <CreateTaskButton @create="createTask" />
    </AppLayout>
</template>
