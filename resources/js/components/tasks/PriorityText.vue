<script setup lang="ts">
import { TaskPriority } from '@/enums/TaskPriority';

const { priority } = defineProps<{
    priority: TaskPriority;
}>();

const badgeClass: Record<TaskPriority, string> = {
    [TaskPriority.HIGH]:   'bg-black/[0.07] text-[#333] border-black/[0.09] dark:bg-white/[0.1] dark:text-[#ccc] dark:border-white/[0.1]',
    [TaskPriority.MEDIUM]: 'bg-black/[0.04] text-[#555] border-black/[0.06] dark:bg-white/[0.05] dark:text-[#999] dark:border-white/[0.06]',
    [TaskPriority.LOW]:    'bg-black/[0.03] text-[#888] border-black/[0.04] dark:bg-white/[0.03] dark:text-[#666] dark:border-white/[0.04]',
    [TaskPriority.NONE]:   '',
};

const label: Record<TaskPriority, string> = {
    [TaskPriority.HIGH]:   'High',
    [TaskPriority.MEDIUM]: 'Medium',
    [TaskPriority.LOW]:    'Low',
    [TaskPriority.NONE]:   '',
};
</script>

<template>
    <span
        v-if="priority !== TaskPriority.NONE"
        class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-medium"
        :class="badgeClass[priority]"
    >
        {{ label[priority] }}
    </span>
</template>
