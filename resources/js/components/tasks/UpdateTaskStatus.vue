<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';
import { TaskStatus } from '@/enums/TaskStatus';
import { router } from '@inertiajs/vue3';
import { updateStatus } from '@/actions/App/Http/Controllers/TaskController';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import {
    Tooltip,
    TooltipContent,
    TooltipProvider,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Check, CircleDot } from 'lucide-vue-next';
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';

const props = defineProps<{ task: Task }>();
const isUpdating = ref<boolean>(false);
const showAlert = ref<boolean>(false);

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
            onSuccess: () => {
                toast.success('Task status updated successfully.');
            },
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

const alertDescription = computed((): string => {
    if (props.task.status === TaskStatus.TO_DO) {
        return 'This will mark the task as in progress.';
    }
    if (props.task.status === TaskStatus.IN_PROGRESS) {
        return 'This will mark the task as completed.';
    }
    return '';
});
</script>

<template>

    <ConfirmAlert
        :request-is-active="isUpdating"
        :description="alertDescription"
        confirm-label="Update status"
        v-model:open="showAlert"
        @submit="updateStatusRequest"
    />

    <TooltipProvider v-if="props.task.status != TaskStatus.COMPLETED">
        <Tooltip>
            <TooltipTrigger as-child>
                <button
                    :disabled="isUpdating"
                    @click="showAlert = true"
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
