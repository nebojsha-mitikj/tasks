<script setup lang="ts">
import { TaskPriority } from '@/enums/TaskPriority';
import { capitalizeFirstLetter } from '@/utils/string';

const { priority } = defineProps<{
    priority: TaskPriority;
}>();
</script>

<template>
    <p class="text-[11px] text-muted-foreground">
        Priority:
        <span class="font-bold">
            {{ capitalizeFirstLetter(priority) }}
        </span>
    </p>
</template>
