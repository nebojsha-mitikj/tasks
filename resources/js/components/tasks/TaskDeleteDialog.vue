<script setup lang="ts">
import { destroy } from '@/actions/App/Http/Controllers/TaskController';
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import { Button } from '@/components/ui/button';
import type { Task } from '@/types/tasks/Task';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{ task: Task }>();

const deleteDialog = ref<boolean>(false);
const isDeleting = ref<boolean>(false);

const deleteTask = (): void => {
    isDeleting.value = true;
    router.delete(destroy(props.task.id), {
        preserveScroll: true,
        onSuccess: () => {
            deleteDialog.value = false;
        },
        onFinish: () => {
            isDeleting.value = false;
        },
    });
};
</script>

<template>
    <AlertDialog v-model:open="deleteDialog">
        <AlertDialogTrigger as-child>
            <button
                class="cursor-pointer rounded p-1 transition hover:bg-destructive/10"
            >
                <Trash2 class="h-4 w-4 text-destructive" />
            </button>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                <AlertDialogDescription>
                    This action cannot be undone. This will permanently delete
                    your task from our servers.
                </AlertDialogDescription>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel :disabled="isDeleting"
                    >Cancel</AlertDialogCancel
                >
                <Button
                    :disabled="isDeleting"
                    class="cursor-pointer"
                    @click="deleteTask"
                >
                    {{ isDeleting ? 'Deleting...' : 'Delete' }}
                </Button>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
