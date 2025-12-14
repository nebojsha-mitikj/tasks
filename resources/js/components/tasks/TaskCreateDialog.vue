<script setup lang="ts">
import { store } from '@/actions/App/Http/Controllers/TaskController';
import { Button } from '@/components/ui/button';
import { Calendar } from '@/components/ui/calendar';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
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
import { router } from '@inertiajs/vue3';
import type { DateValue } from '@internationalized/date';
import { DateFormatter, getLocalTimeZone } from '@internationalized/date';
import { CalendarIcon, Plus } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

const date = ref<DateValue | undefined>();
const isSubmitting = ref<boolean>(false);
const title = ref<string>('');
const description = ref<string>('');
const priority = ref<TaskPriority | ''>('');
const datePopover = ref<boolean>(false);
const createDialog = ref<boolean>(false);

const df = new DateFormatter('en-US', { dateStyle: 'long' });

const resetForm = () => {
    title.value = '';
    description.value = '';
    date.value = undefined;
    priority.value = '';
};

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
    router.post(store(), payload, {
        preserveScroll: true,
        onSuccess: () => {
            createDialog.value = false;
            toast.success('Task created successfully.')
            resetForm();
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
}
</script>

<template>
    <Dialog v-model:open="createDialog">

        <DialogTrigger as-child>
            <button
                type="button"
                class="fixed right-8 bottom-8 inline-flex h-12 w-12
                cursor-pointer items-center justify-center rounded-full
                bg-primary text-primary-foreground shadow-lg transition
                hover:bg-primary/90"
            >
                <Plus class="h-6 w-6" />
            </button>
        </DialogTrigger>

        <DialogContent class="sm:max-w-2xl">
            <DialogHeader>
                <DialogTitle>Add a new task</DialogTitle>
                <DialogDescription>
                    Create a task to plan your work.
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
                    @click="createDialog = false"
                    :disabled="isSubmitting"
                >
                    Cancel
                </Button>

                <Button
                    type="button"
                    @click="submit"
                    :disabled="isSubmitting || !title || !date || !priority"
                >
                    {{ isSubmitting ? 'Creating...' : 'Create task' }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
