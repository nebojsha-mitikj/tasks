<script setup lang="ts">
import {
    store,
    update,
} from '@/actions/App/Http/Controllers/RecurringTaskTemplateController';
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
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { TaskPriority } from '@/enums/TaskPriority';
import { TaskRecur } from '@/enums/TaskRecur';
import { Weekday } from '@/enums/Weekday';
import { AppPageProps } from '@/types';
import type { Label } from '@/types/labels/Label';
import { CreateRecurringTaskTemplatePayload } from '@/types/recurring-task-templates/CreateRecurringTaskTemplatePayload';
import { RecurringTaskTemplate } from '@/types/recurring-task-templates/RecurringTaskTemplate';
import { capitalizeFirstLetter } from '@/utils/string';
import type { RequestPayload } from '@inertiajs/core';
import { router, usePage } from '@inertiajs/vue3';
import { AcceptableValue } from 'reka-ui';
import { computed, ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const { template, labels } = defineProps<{
    template: RecurringTaskTemplate | null;
    labels: Label[];
}>();

const recurOptions = Object.values(TaskRecur);
const weekdayOptions = Object.values(Weekday);
const recur = ref<TaskRecur | null>(null);
const weekdays = ref<Weekday[]>([]);

const isSubmitting = ref<boolean>(false);
const title = ref<string>('');
const description = ref<string>('');
const priority = ref<TaskPriority | ''>('');
const page = usePage<AppPageProps>();
const selectedLabelIds = ref<number[]>(
    (template?.labels ?? []).map((l) => l.id),
);
const open = defineModel<boolean>('open', { default: false });
const submitButtonText = computed(() => {
    if (isSubmitting.value) {
        return template === null ? 'Creating...' : 'Updating...';
    }
    return template === null ? 'Create task' : 'Update task';
});

const resetForm = () => {
    title.value = '';
    description.value = '';
    priority.value = '';
    selectedLabelIds.value = (template?.labels ?? []).map((l) => l.id);
    recur.value = null;
    weekdays.value = [];
};

watch(
    () => template,
    (t: RecurringTaskTemplate | null) => {
        if (!t) {
            resetForm();
            return;
        }
        title.value = t.title;
        description.value = t.description ?? '';
        priority.value = t.priority;
        selectedLabelIds.value = t.labels.map((l) => l.id);
        weekdays.value = t.weekdays ?? [];
        recur.value = t.recur ?? null;
    },
    { immediate: true },
);

const isSubmitDisabled = computed(() => {
    if (isSubmitting.value) return true;
    if (!title.value) return true;
    if (!priority.value) return true;
    if (!recur.value) return true;
    if (recur.value === TaskRecur.WEEKLY) {
        return weekdays.value.length === 0;
    }
    return false;
});

const onLabelsChange = (val: AcceptableValue): void => {
    selectedLabelIds.value = val as number[];
};

const submit = (): void => {
    if (
        title.value.length === 0 ||
        priority.value === '' ||
        recur.value == null
    ) {
        return;
    }
    submitRequest({
        title: title.value,
        description: description.value,
        priority: priority.value,
        label_ids: selectedLabelIds.value,
        recur: recur.value,
        weekdays: recur.value === TaskRecur.WEEKLY ? weekdays.value : [],
    });
};

const submitRequest = (
    payload: RequestPayload & CreateRecurringTaskTemplatePayload,
): void => {
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
    if (template === null) {
        router.post(store(), payload, options);
    } else {
        router.put(update(template.id), payload, options);
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
                    <template v-if="template == null">
                        Add a new recurring task
                    </template>
                    <template v-else> Update recurring task </template>
                </DialogTitle>
                <DialogDescription>
                    <template v-if="template == null">
                        Create a recurring task to plan your work.
                    </template>
                    <template v-else>
                        Update this recurring task to keep your plan on track.
                    </template>
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4 py-2">
                <div>
                    <Input
                        v-model="title"
                        placeholder="Task title"
                        class="mt-1"
                    />
                </div>

                <div>
                    <Textarea
                        v-model="description"
                        placeholder="Add description"
                        class="mt-1"
                    />
                </div>

                <Select v-model="recur">
                    <SelectTrigger class="w-full max-w-[280px]">
                        <SelectValue placeholder="Recurring option" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="option in recurOptions"
                                :key="option"
                                :value="option"
                            >
                                {{ capitalizeFirstLetter(option) }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
                <Select
                    v-model="weekdays"
                    multiple
                    v-if="recur === TaskRecur.WEEKLY"
                >
                    <SelectTrigger class="w-full max-w-[280px]">
                        <SelectValue placeholder="Choose recurring days" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="option in weekdayOptions"
                                :key="option"
                                :value="option"
                            >
                                {{ capitalizeFirstLetter(option) }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>

                <Select v-model="priority">
                    <SelectTrigger class="w-full max-w-[280px]">
                        <SelectValue placeholder="Select priority" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem
                            :value="availablePriority"
                            :key="availablePriority"
                            v-for="availablePriority in Object.values(
                                TaskPriority,
                            )"
                        >
                            {{ capitalizeFirstLetter(availablePriority) }}
                        </SelectItem>
                    </SelectContent>
                </Select>

                <Select
                    multiple
                    :model-value="selectedLabelIds"
                    @update:model-value="onLabelsChange"
                >
                    <SelectTrigger class="w-full max-w-[280px]">
                        <SelectValue placeholder="Select labels" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectGroup>
                            <SelectItem
                                v-for="label in labels"
                                :key="label.id"
                                :value="label.id"
                            >
                                {{ label.name }}
                            </SelectItem>
                        </SelectGroup>
                    </SelectContent>
                </Select>
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
                    :disabled="isSubmitDisabled"
                >
                    {{ submitButtonText }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
