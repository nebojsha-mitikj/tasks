<script setup lang="ts">
import ConfirmAlert from '@/components/ui-custom/ConfirmAlert.vue';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { RouteDefinition } from '@/wayfinder';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const props = defineProps<{
    deleteUrl: RouteDefinition<'delete'>;
}>();
const isDeleting = ref<boolean>(false);
const showAlert = ref<boolean>(false);

const onDelete = (): void => {
    isDeleting.value = true;
    router.delete(props.deleteUrl, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Deleted successfully.');
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
        description="This action cannot be undone. This will permanently delete it from our servers."
        confirm-label="Delete"
        v-model:open="showAlert"
        @submit="onDelete"
    />
    <TooltipButton
        @click="showAlert = true"
        :icon="Trash2"
        tooltip="Delete"
        variant="destructive"
        :disabled="isDeleting"
    />
</template>
