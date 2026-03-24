import type { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { ref } from 'vue';

export function useRecurringTemplateDialog() {
    const dialogOpen = ref(false);
    const editingTemplate = ref<RecurringTaskTemplate | null>(null);

    const editTemplate = (template: RecurringTaskTemplate): void => {
        editingTemplate.value = template;
        dialogOpen.value = true;
    };

    const createTemplate = (): void => {
        editingTemplate.value = null;
        dialogOpen.value = true;
    };

    return {
        dialogOpen,
        editingTemplate,
        editTemplate,
        createTemplate,
    };
}
