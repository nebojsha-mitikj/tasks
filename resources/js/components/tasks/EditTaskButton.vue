<script setup lang="ts">
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Pencil } from 'lucide-vue-next';
import { Task } from '@/types/tasks/Task';

const { task } = defineProps<{ task: Task }>();
const emit = defineEmits<{ (e: 'edit', task: Task): void }>();
</script>

<template>
    <Tooltip>
        <TooltipTrigger as-child>
            <button
                type="button"
                class="cursor-pointer rounded p-1 text-muted-foreground
                transition hover:bg-muted hover:text-foreground"
                @click="emit('edit', task)"
            >
                <Pencil class="h-4 w-4" />
            </button>
        </TooltipTrigger>
        <TooltipContent>Edit task</TooltipContent>
    </Tooltip>
</template>
