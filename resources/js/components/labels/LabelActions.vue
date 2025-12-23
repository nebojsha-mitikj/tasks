<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { ref } from 'vue';
import { IconAction } from '@/types/ui/IconAction';
import { ChevronRight, Pencil, Trash2 } from 'lucide-vue-next';
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';
import { router } from '@inertiajs/vue3';
import { destroy } from '@/actions/App/Http/Controllers/LabelController';
import { toast } from 'vue-sonner';
import { Label } from '@/types/Label';

const { label } = defineProps<{ label: Label }>();

const icons = ref<IconAction[]>([
    { action: 'edit', tooltip: 'Edit label', icon: Pencil },
    { action: 'delete', tooltip: 'Delete label', icon: Trash2, variant: 'destructive' },
    { action: 'view', tooltip: 'View tasks', icon: ChevronRight }
]);
const isDeleting = ref<boolean>(false);
const showAlert = ref<boolean>(false);

const deleteLabel = (): void => {
    isDeleting.value = true;
    router.delete(destroy(label.id), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Label deleted successfully.');
        },
        onFinish: () => {
            isDeleting.value = false;
        },
    });
};

const handleAction = (action: 'edit' | 'delete' | 'view'): void => {
    if (action === 'edit') {

        return;
    }
    if (action === 'delete') {
        showAlert.value = true;
        return;
    }
    router.visit('/labels/' + label.id);
};
</script>

<template>
    <div class="flex gap-1">
        <TooltipButton
            v-for="icon in icons"
            :key="icon.tooltip"
            :tooltip="icon.tooltip"
            :icon="icon.icon"
            :variant="icon.variant"
            @click="handleAction(icon.action)"
        />

        <ConfirmAlert
            :request-is-active="isDeleting"
            description="This action cannot be undone. This will permanently delete your label from our servers."
            confirm-label="Delete"
            v-model:open="showAlert"
            @submit="deleteLabel"
        />
    </div>
</template>
