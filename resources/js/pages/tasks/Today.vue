<script setup lang="ts">
import PageTitle from '@/components/tasks/PageTitle.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { TaskStatus } from '@/enums/TaskStatus';
import AppLayout from '@/layouts/AppLayout.vue';
import { today } from '@/routes/tasks';
import { AppPageProps, type BreadcrumbItem } from '@/types';
import { type Task } from '@/types/tasks/Task';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import TaskCreateDialog from '@/components/tasks/TaskCreateDialog.vue';

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
</script>

<template>
    <Head title="Today" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
            <PageTitle
                :title="title"
                subtitle="Your scheduled tasks for today."
            />
            <Tasks :tasks="tasks" />
        </div>
        <TaskCreateDialog/>
    </AppLayout>
</template>
