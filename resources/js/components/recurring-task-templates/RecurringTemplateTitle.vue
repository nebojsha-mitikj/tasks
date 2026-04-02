<script setup lang="ts">
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';

const { template } = defineProps<{
    template: RecurringTaskTemplate;
}>();
</script>

<template>
    <div class="flex items-center gap-2">
        <p class="text-[15px] font-medium text-[#111] dark:text-white">{{ template.title }}</p>
        <span
            class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] font-medium"
            :class="template.is_active
                ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-400 dark:border-emerald-800/40'
                : 'bg-black/[0.03] text-[#aaa] border-black/[0.04] dark:bg-white/[0.03] dark:text-[#555] dark:border-white/[0.04]'"
        >
            {{ template.is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
</template>
