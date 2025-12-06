<script setup lang="ts">
import TaskDeleteDialog from '@/components/tasks/TaskDeleteDialog.vue';
import type { Task } from '@/types/tasks/Task';
import { Link } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';

const props = defineProps<{ task: Task }>();
</script>

<template>
    <div>
        <Link class="rounded p-1 transition hover:bg-muted">
            <Pencil
                class="h-4 w-4 text-muted-foreground hover:text-foreground"
            />
        </Link>
        <TaskDeleteDialog :task="props.task" />
    </div>
</template>
