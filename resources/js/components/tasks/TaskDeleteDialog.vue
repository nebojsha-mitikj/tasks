<script setup lang="ts">
import { destroy } from '@/actions/App/Http/Controllers/TaskController';
import type { Task } from '@/types/tasks/Task';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';

const props = defineProps<{ task: Task }>();
const isDeleting = ref<boolean>(false);
const showAlert = ref<boolean>(false);

const deleteTask = (): void => {
    isDeleting.value = true;
    router.delete(destroy(props.task.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Task deleted successfully.');
        },
        onFinish: () => {
            isDeleting.value = false;
        },
    });
};
</script>

<template>
    <ConfirmAlert
        :request-is-active="isDeleting"
        description="This action cannot be undone. This will permanently delete your task from our servers."
        confirm-label="Delete"
        v-model:open="showAlert"
        @submit="deleteTask"
    />
    <TooltipButton
        @click="showAlert = true"
        :icon="Trash2"
        tooltip="Delete task"
        variant="destructive"
    />
</template>
