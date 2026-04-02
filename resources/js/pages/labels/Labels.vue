<script setup lang="ts">
import LabelFormDialog from '@/components/labels/LabelFormDialog.vue';
import LabelHeader from '@/components/labels/LabelHeader.vue';
import LabelList from '@/components/labels/LabelList.vue';
import CreateTaskButton from '@/components/tasks/CreateTaskButton.vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import { useLabelDialog } from '@/composables/useLabelDialog';
import { useTaskDialog } from '@/composables/useTaskDialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { index as getLabels } from '@/routes/labels';
import { type BreadcrumbItem } from '@/types';
import { Label } from '@/types/labels/Label';
import { Head } from '@inertiajs/vue3';

const { dialogOpen, editingLabel, editLabel, createLabel } = useLabelDialog();
const { dialogOpen: taskDialogOpen, editingTask, createTask } = useTaskDialog();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Labels', href: getLabels().url },
];

const { labels } = defineProps<{ labels: Label[] }>();
</script>

<template>
    <Head title="Labels" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-8 w-full max-w-4xl space-y-4">
            <LabelHeader @create="createLabel" />
            <LabelList :labels="labels" @edit="editLabel" />
        </div>
        <LabelFormDialog :label="editingLabel" v-model:open="dialogOpen" />
        <TaskFormDialog
            :labels="labels"
            v-model:open="taskDialogOpen"
            :task="editingTask"
        />
        <CreateTaskButton @create="createTask" />
    </AppLayout>
</template>
