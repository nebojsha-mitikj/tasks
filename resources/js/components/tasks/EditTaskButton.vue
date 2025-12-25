<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { Task } from '@/types/tasks/Task';
import { Pencil } from 'lucide-vue-next';

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
