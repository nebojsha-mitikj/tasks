<script setup lang="ts">
import PageTitle from '@/components/tasks/PageTitle.vue';
import Tasks from '@/components/tasks/Tasks.vue';
import { Task } from '@/types/tasks/Task';

const emit = defineEmits<{
    (e: 'editTask', task: Task): void;
}>();

const props = defineProps<{
    tasks: Task[];
    title: string;
    subtitle: string;
}>();
</script>

<template>
    <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
        <PageTitle :title="props.title" :subtitle="props.subtitle" />
        <Tasks :tasks="props.tasks" @edit="emit('editTask', $event)" />
    </div>
</template>
