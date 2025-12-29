<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { today } from '@/routes/tasks';
import { type Task } from '@/types/tasks/Task';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import CreateTaskButton from '@/components/tasks/CreateTaskButton.vue';
import TasksSection from '@/components/tasks/TasksSection.vue';
import { useTaskDialog } from '@/composables/useTaskDialog';
import { countCompleted } from '@/utils/taskCounts'
import type { BreadcrumbItem } from '@/types';
import EmptyTasksMessage from '@/components/tasks/EmptyTasksMessage.vue';
import type { Label } from '@/types/labels/Label';

const { dialogOpen, editingTask, editTask, createTask } = useTaskDialog();
const { tasks } = defineProps<{
    tasks: Task[];
    labels: Label[];
}>();
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Today', href: today().url }];

const title = computed(() =>
    tasks.length > 0
        ? `Today - ${countCompleted(tasks)}/${tasks.length} complete`
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
            :labels="labels"
            :title="title"
            subtitle="Your scheduled tasks for today."
        />
        <EmptyTasksMessage v-else title="No tasks for today" />
        <TaskFormDialog
            :labels="labels"
            v-model:open="dialogOpen"
            :task="editingTask"
        />
        <CreateTaskButton @create="createTask" />
    </AppLayout>
</template>
