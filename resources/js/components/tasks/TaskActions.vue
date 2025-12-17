<script setup lang="ts">
import TaskDeleteDialog from '@/components/tasks/TaskDeleteDialog.vue';
import type { Task } from '@/types/tasks/Task';
import { Pencil } from 'lucide-vue-next';
import UpdateTaskStatus from '@/components/tasks/UpdateTaskStatus.vue';
const emit = defineEmits<{
    (e: 'edit', task: Task): void;
}>();
const props = defineProps<{ task: Task }>();
</script>

<template>
    <div>
        <UpdateTaskStatus :task="props.task"></UpdateTaskStatus>

        <button
            type="button"
            class="rounded p-1 transition hover:bg-muted"
            @click="emit('edit', props.task)"
        >
            <Pencil
                class="h-4 w-4 text-muted-foreground hover:text-foreground"
            />
        </button>

        <TaskDeleteDialog :task="props.task" />
    </div>
</template>
