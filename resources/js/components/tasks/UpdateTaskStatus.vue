<script setup lang="ts">
import type { Task } from '@/types/tasks/Task';
import { TaskStatus } from '@/enums/TaskStatus';
import { router } from '@inertiajs/vue3';
import { updateStatus } from '@/actions/App/Http/Controllers/TaskController';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import { Check, CircleDot } from 'lucide-vue-next';
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { Component } from 'vue';

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

const icon = computed((): Component|null => {
    if (props.task.status === TaskStatus.TO_DO) {
        return CircleDot;
    }
    if (props.task.status === TaskStatus.IN_PROGRESS) {
        return Check;
    }
    return null;
});

const tooltipText = computed((): string => {
    if (props.task.status === TaskStatus.TO_DO) {
        return 'Mark as in progress';
    }
    if (props.task.status === TaskStatus.IN_PROGRESS) {
        return 'Mark as complete';
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
    <TooltipButton
        v-if="icon !== null"
        :icon="icon"
        :tooltip="tooltipText"
        :disabled="isUpdating"
        @click="showAlert = true"
    />
</template>
