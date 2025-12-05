<script setup lang="ts">
import { TaskStatus as TaskStatusEnum } from '@/enums/TaskStatus';
import { Task } from '@/types/tasks/Task';
import {capitalizeFirstLetter} from '@/utils/string';

const props = defineProps<{
    task: Task
}>();
</script>

<template>
    <p
        v-if="props.task.status !== TaskStatusEnum.COMPLETED"
        class="text-[11px] text-muted-foreground"
    >
        Priority:
        <span class="font-bold">
            {{capitalizeFirstLetter(task.priority) }}
        </span>
    </p>
</template>

