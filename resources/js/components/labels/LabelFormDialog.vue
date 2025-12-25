<script setup lang="ts">
import { store, update } from '@/actions/App/Http/Controllers/LabelController';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import type { AppPageProps } from '@/types';
import type { CreateLabelPayload } from '@/types/labels/CreateLabelPayload';
import type { Label } from '@/types/labels/Label';
import type { RequestPayload } from '@inertiajs/core';
import { router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const isSubmitting = ref<boolean>(false);
const name = ref<string>('');

const page = usePage<AppPageProps>();

const { label } = defineProps<{
    label: Label | null;
}>();

const open = defineModel<boolean>('open', { default: false });

const submitButtonText = computed(() => {
    if (isSubmitting.value) {
        return label === null ? 'Creating...' : 'Updating...';
    }
    return label === null ? 'Create label' : 'Update label';
});

const resetForm = () => {
    name.value = '';
};

watch(
    () => label,
    (t: Label | null) => {
        if (!t) {
            resetForm();
            return;
        }
        name.value = t.name;
    },
    { immediate: true },
);

const submit = (): void => {
    if (name.value.length === 0) {
        return;
    }
    submitRequest({ name: name.value });
};

const submitRequest = (payload: RequestPayload & CreateLabelPayload): void => {
    isSubmitting.value = true;
    const options = {
        preserveScroll: true,
        onSuccess: () => {
            open.value = false;
            toast.success(page.props.flash?.success ?? '');
            resetForm();
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    };
    if (label === null) {
        router.post(store(), payload, options);
    } else {
        router.put(update(label.id), payload, options);
    }
};
</script>

<template>
    <Dialog v-model:open="open">
        <DialogContent
            class="sm:max-w-2xl"
            @open-auto-focus="(e) => e.preventDefault()"
        >
            <DialogHeader>
                <DialogTitle>
                    <template v-if="label == null"> Add a new label </template>
                    <template v-else> Update label </template>
                </DialogTitle>
                <DialogDescription>
                    <template v-if="label == null">
                        Create a label to organize your work.
                    </template>
                    <template v-else>
                        Update this label to organize your work.
                    </template>
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4 py-2">
                <div>
                    <Input
                        v-model="name"
                        placeholder="Label title"
                        class="mt-1"
                    />
                </div>
            </div>

            <DialogFooter>
                <Button
                    type="button"
                    variant="outline"
                    @click="open = false"
                    :disabled="isSubmitting"
                >
                    Cancel
                </Button>

                <Button
                    type="button"
                    @click="submit"
                    :disabled="isSubmitting || !name"
                >
                    {{ submitButtonText }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
