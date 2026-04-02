<script setup lang="ts">
import { TaskRecur } from '@/enums/TaskRecur';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { capitalizeFirstLetter } from '@/utils/string';

const { template } = defineProps<{ template: RecurringTaskTemplate }>();
</script>

<template>
    <span
        class="inline-flex items-center rounded-full border border-black/[0.1] bg-neutral-50 px-2 py-0.5 text-[10px] font-semibold text-neutral-600 dark:border-white/[0.1] dark:bg-neutral-900 dark:text-neutral-400"
    >
        {{ capitalizeFirstLetter(template.recur) }}
    </span>
    <template v-if="template.recur === TaskRecur.WEEKLY">
        <span
            v-for="weekday in template.weekdays ?? []"
            :key="template.id + weekday"
            class="inline-flex items-center rounded-full border border-black/[0.1] bg-neutral-50 px-2 py-0.5 text-[10px] font-semibold text-neutral-600 dark:border-white/[0.1] dark:bg-neutral-900 dark:text-neutral-400"
        >
            {{ capitalizeFirstLetter(weekday) }}
        </span>
    </template>
</template>
