<script setup lang="ts">
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';

const { template } = defineProps<{
    template: RecurringTaskTemplate;
}>();
</script>

<template>
    <p class="font-medium">
        {{ template.title }}
    </p>
</template>
