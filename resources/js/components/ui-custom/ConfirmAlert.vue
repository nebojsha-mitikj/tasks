<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import { computed } from 'vue';

const emit = defineEmits<{
    (e: 'submit'): void;
    (e: 'update:open', value: boolean): void;
}>();

const props = withDefaults(
    defineProps<{
        open: boolean;
        title?: string;
        description?: string;
        requestIsActive: boolean;
        confirmLabel?: string;
    }>(),
    {
        title: 'Are you absolutely sure?',
        description:
            'Please confirm that you want to continue with this action.',
        confirmLabel: 'Confirm',
    },
);

const openProxy = computed({
    get: () => props.open,
    set: (value: boolean) => emit('update:open', value),
});

const submit = (): void => {
    emit('submit');
    emit('update:open', false);
};
</script>

<template>
    <AlertDialog v-model:open="openProxy">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ props.title }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ props.description }}
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel :disabled="props.requestIsActive">
                    Cancel
                </AlertDialogCancel>
                <Button
                    :disabled="props.requestIsActive"
                    class="cursor-pointer"
                    @click="submit"
                >
                    {{
                        props.requestIsActive
                            ? 'Processing...'
                            : props.confirmLabel
                    }}
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
