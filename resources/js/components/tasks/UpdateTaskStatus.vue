<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';
import { TaskStatus } from '@/enums/TaskStatus';
import { router } from '@inertiajs/vue3';
import { updateStatus } from '@/actions/App/Http/Controllers/TaskController';
import { computed, ref } from 'vue';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Check, CircleDot } from 'lucide-vue-next';

const props = defineProps<{ task: Task }>();
const isUpdating = ref<boolean>(false);

const updateStatusRequest = (): void => {
    if (isUpdating.value || props.task.status === TaskStatus.COMPLETED) {
        return;
    }
    let status = TaskStatus.IN_PROGRESS;
    if (props.task.status === TaskStatus.IN_PROGRESS) {
        status = TaskStatus.COMPLETED;
    }
    isUpdating.value = true;
    router.put(
        updateStatus(props.task.id),
        {
            status: status,
        },
        {
            preserveScroll: true,
            onFinish: () => {
                isUpdating.value = false;
            },
        },
    );
};

const tooltipText = computed((): string => {
    if (props.task.status === TaskStatus.TO_DO) {
        return 'In progress';
    }
    if (props.task.status === TaskStatus.IN_PROGRESS) {
        return 'Complete';
    }
    return '';
});
</script>

<template>
    <TooltipProvider v-if="props.task.status != TaskStatus.COMPLETED">
        <Tooltip>
            <TooltipTrigger as-child>
                <button
                    :disabled="isUpdating"
                    @click="updateStatusRequest"
                    class="cursor-pointer rounded p-1 transition hover:bg-muted"
                >
                    <CircleDot
                        v-if="props.task.status === TaskStatus.TO_DO"
                        class="h-4 w-4 text-muted-foreground hover:text-foreground"
                    />
                    <Check
                        v-else-if="props.task.status === TaskStatus.IN_PROGRESS"
                        class="h-4 w-4 text-muted-foreground hover:text-foreground"
                    />
                </button>
            </TooltipTrigger>
            <TooltipContent>
                <p>{{ tooltipText }}</p>
            </TooltipContent>
        </Tooltip>
    </TooltipProvider>
</template>
