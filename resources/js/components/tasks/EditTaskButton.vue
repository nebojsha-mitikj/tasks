<script setup lang="ts">
import { Pencil } from 'lucide-vue-next';
import { Task } from '@/types/tasks/Task';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';

const { task } = defineProps<{ task: Task }>();
const emit = defineEmits<{ (e: 'edit', task: Task): void }>();
</script>

<template>
    <TooltipButton
        tooltip="Edit task"
        :icon="Pencil"
        @click="emit('edit', task)"
    />
</template>
