<script setup lang="ts">
import PageTitle from '@/components/tasks/PageTitle.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { TaskStatus } from '@/enums/TaskStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { today } from '@/routes/tasks';
import { AppPageProps, type BreadcrumbItem } from '@/types';
import { type Task } from '@/types/tasks/Task';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import TaskFormDialog from '@/components/tasks/TaskFormDialog.vue';
import { Plus } from 'lucide-vue-next';

const page = usePage<AppPageProps<{ tasks: Task[] }>>();
const tasks = computed(() => page.props.tasks ?? []);
const breadcrumbs: BreadcrumbItem[] = [{ title: 'Today', href: today().url }];

const completeCount = computed(
    () =>
        tasks.value.filter((task) => task.status === TaskStatus.COMPLETED)
            .length,
);

const title = computed(() =>
    tasks.value.length > 0
        ? `Today - ${completeCount.value}/${tasks.value.length} complete`
        : 'Today',
);

const dialogOpen = ref<boolean>(false);
const editingTask = ref<Task | null>(null);

const editTask = (task: Task): void => {
    editingTask.value = task;
    dialogOpen.value = true;
};

const createTask = (): void => {
    editingTask.value = null;
    dialogOpen.value = true;
};
</script>

<template>
    <Head title="Today" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
            <PageTitle
                :title="title"
                subtitle="Your scheduled tasks for today."
            />
            <Tasks :tasks="tasks" @edit="editTask"/>
        </div>

        <TaskFormDialog
            v-model:open="dialogOpen"
            :task="editingTask"
        />

        <button
            @click="createTask"
            type="button"
            class="fixed right-8 bottom-8 inline-flex h-12 w-12
                cursor-pointer items-center justify-center rounded-full
                bg-primary text-primary-foreground shadow-lg transition
                hover:bg-primary/90"
        >
            <Plus class="h-6 w-6" />
        </button>
    </AppLayout>
</template>
