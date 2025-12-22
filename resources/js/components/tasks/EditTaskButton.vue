<script setup lang="ts">
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Pencil } from 'lucide-vue-next';
import { Task } from '@/types/tasks/Task';
import { Button } from '@/components/ui/button';

const { task } = defineProps<{ task: Task }>();
const emit = defineEmits<{ (e: 'edit', task: Task): void }>();
</script>

<template>
    <Tooltip>
        <TooltipTrigger as-child>
            <Button
                size="icon"
                variant="ghost"
                class="rounded-full cursor-pointer"
                @click="emit('edit', task)"
            >
                <Pencil class="size-5 text-muted-foreground" />
            </Button>
        </TooltipTrigger>
        <TooltipContent>Edit task</TooltipContent>
    </Tooltip>
</template>
