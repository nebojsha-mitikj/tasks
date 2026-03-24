<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { TaskRecur } from '@/enums/TaskRecur';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { capitalizeFirstLetter } from '@/utils/string';

const { template } = defineProps<{ template: RecurringTaskTemplate }>();
</script>

<template>
    <p class="text-[11px] text-muted-foreground">
        Recur pattern:
        <span class="font-bold">
            {{ capitalizeFirstLetter(template.recur) }}
        </span>
    </p>
    <p
        v-if="template.recur === TaskRecur.WEEKLY"
        class="text-[11px] text-muted-foreground"
    >
        Days:
        <Badge
            variant="secondary"
            v-for="weekday in template.weekdays ?? []"
            :key="template.id + weekday"
            class="ml-2 font-bold"
        >
            {{ capitalizeFirstLetter(weekday) }}
        </Badge>
    </p>
</template>
