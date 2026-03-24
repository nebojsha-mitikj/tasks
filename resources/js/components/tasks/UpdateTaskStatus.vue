<script setup lang="ts">
import { materialize, updateStatus } from '@/actions/App/Http/Controllers/TaskController';
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { TaskStatus } from '@/enums/TaskStatus';
import type { Task } from '@/types/tasks/Task';
import { router } from '@inertiajs/vue3';
import { Check, CircleDot } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

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

    const options = {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Task status updated successfully.');
        },
        onFinish: () => {
            isUpdating.value = false;
        },
    };

    if (props.task.is_virtual && props.task.recurring_task_template_id) {
        router.post(
            materialize(props.task.recurring_task_template_id),
            { date: props.task.date, status },
            options,
        );
    } else {
        router.put(updateStatus(props.task.id), { status }, options);
    }
};

const statusConfig = computed(() => {
    if (props.task.status === TaskStatus.TO_DO) {
        return {
            icon: CircleDot,
            tooltip: 'Mark as in progress',
            description: 'This will mark the task as in progress.',
        };
    }

    if (props.task.status === TaskStatus.IN_PROGRESS) {
        return {
            icon: Check,
            tooltip: 'Mark as complete',
            description: 'This will mark the task as completed.',
        };
    }

    return null;
});
</script>

<template>
    <ConfirmAlert
        :request-is-active="isUpdating"
        :description="statusConfig?.description ?? ''"
        confirm-label="Update status"
        v-model:open="showAlert"
        @submit="updateStatusRequest"
    />

    <TooltipButton
        v-if="statusConfig"
        :icon="statusConfig.icon"
        :tooltip="statusConfig.tooltip"
        :disabled="isUpdating"
        @click="showAlert = true"
    />
</template>
