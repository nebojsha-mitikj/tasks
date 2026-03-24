<script setup lang="ts">
import { toggle } from '@/actions/App/Http/Controllers/RecurringTaskTemplateController';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { AppPageProps } from '@/types';
import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { router, usePage } from '@inertiajs/vue3';
import { ToggleLeft, ToggleRight } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const page = usePage<AppPageProps>();

const { template } = defineProps<{
    template: RecurringTaskTemplate;
}>();

const isSubmitting = ref<boolean>(false);

const toggleTemplate = (): void => {
    if (isSubmitting.value) return;
    isSubmitting.value = true;
    const options = {
        preserveScroll: true,
        onSuccess: () => {
            toast.success(page.props.flash?.success ?? '');
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    };
    router.put(toggle(template.id), {}, options);
};
</script>

<template>
    <TooltipButton
        @click="toggleTemplate"
        :icon="template.is_active ? ToggleRight : ToggleLeft"
        :tooltip="
            (template.is_active ? 'Deactivate' : 'Activate') + ' template'
        "
        :disabled="isSubmitting"
    />
</template>
