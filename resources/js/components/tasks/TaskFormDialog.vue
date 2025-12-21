<script setup lang="ts">
import { store, update } from '@/actions/App/Http/Controllers/TaskController';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
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
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { TaskPriority } from '@/enums/TaskPriority';
import { cn } from '@/lib/utils';
import type { CreateTaskPayload } from '@/types/tasks/CreateTaskPayload';
import { capitalizeFirstLetter } from '@/utils/string';
import type { RequestPayload } from '@inertiajs/core';
import { router, usePage } from '@inertiajs/vue3';
import type { DateValue } from '@internationalized/date';
import { parseDate } from '@internationalized/date';
import { DateFormatter, getLocalTimeZone, today } from '@internationalized/date';
import { CalendarIcon } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import { toast } from 'vue-sonner';
import type { Task } from '@/types/tasks/Task';
import { AppPageProps } from '@/types';

const date = ref<DateValue | undefined>();
const isSubmitting = ref<boolean>(false);
const title = ref<string>('');
const description = ref<string>('');
const priority = ref<TaskPriority | ''>('');
const datePopover = ref<boolean>(false);
const page = usePage<AppPageProps>();

const df = new DateFormatter('en-US', { dateStyle: 'long' });

const props = defineProps<{
    task: Task | null;
}>();

const open = defineModel<boolean>('open', { default: false });

const submitButtonText = computed(() => {
    if (isSubmitting.value) {
        return props.task === null ? 'Creating...' : 'Updating...';
    }
    return props.task === null ? 'Create task' : 'Update task';
});

const resetForm = () => {
    title.value = '';
    description.value = '';
    date.value = undefined;
    priority.value = '';
};

watch(
    () => props.task,
    (t: Task | null) => {
        if (!t) {
            resetForm();
            return;
        }
        title.value = t.title;
        description.value = t.description ?? '';
        priority.value = t.priority;
        const dateOnly = t.date.includes('T') ? t.date.split('T')[0] : t.date;
        date.value = parseDate(dateOnly);
    },
    { immediate: true },
);

const submit = (): void => {
    if (
        title.value.length === 0 ||
        date.value == null ||
        priority.value === ''
    ) {
        return;
    }
    submitRequest({
        title: title.value,
        description: description.value,
        date: date.value.toString(),
        priority: priority.value,
    });
};

const submitRequest = (payload: RequestPayload & CreateTaskPayload): void => {
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
    if (props.task === null) {
        router.post(store(), payload, options);
    } else {
        router.put(update(props.task.id), payload, options);
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
                    <template v-if="props.task == null">
                        Add a new task
                    </template>
                    <template v-else> Update task </template>
                </DialogTitle>
                <DialogDescription>
                    <template v-if="props.task == null">
                        Create a task to plan your work.
                    </template>
                    <template v-else>
                        Update this task to keep your plan on track.
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

                <Popover v-model:open="datePopover">
                    <PopoverTrigger as-child>
                        <Button
                            variant="outline"
                            :class="
                                cn(
                                    'w-full max-w-[280px] justify-start text-left font-normal',
                                    !date && 'text-muted-foreground',
                                )
                            "
                        >
                            <CalendarIcon class="mr-2 h-4 w-4" />
                            {{
                                date
                                    ? df.format(date.toDate(getLocalTimeZone()))
                                    : 'Pick a date'
                            }}
                        </Button>
                    </PopoverTrigger>
                    <PopoverContent class="w-auto p-0" align="center">
                        <Calendar
                            v-model="date"
                            :initial-focus="true"
                            layout="month-and-year"
                            :minValue="today(getLocalTimeZone())"
                            @update:model-value="
                                (value) => {
                                    if (value) {
                                        date = value;
                                        datePopover = false;
                                    }
                                }
                            "
                        />
                    </PopoverContent>
                </Popover>

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
                    :disabled="isSubmitting || !title || !date || !priority"
                >
                    {{ submitButtonText }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
