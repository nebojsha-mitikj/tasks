<script setup lang="ts">
import { updateLabels } from '@/actions/App/Http/Controllers/TaskController';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import type { Label } from '@/types/labels/Label';
import type { Task } from '@/types/tasks/Task';
import { router } from '@inertiajs/vue3';
import { Tag } from 'lucide-vue-next';
import { AcceptableValue } from 'reka-ui';
import { ref, watch } from 'vue';

const props = defineProps<{ task: Task; labels: Label[] }>();

const selectedLabelIds = ref<number[]>(
    (props.task.labels ?? []).map((l) => l.id),
);

watch(
    () => props.task.labels,
    (labels) => {
        selectedLabelIds.value = (labels ?? []).map((l) => l.id);
    },
);

const onLabelsChange = (val: AcceptableValue): void => {
    selectedLabelIds.value = val as number[];
    router.put(
        updateLabels(props.task.id),
        { label_ids: selectedLabelIds.value },
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};
</script>

<template>
    <Select
        @update:model-value="onLabelsChange"
        :model-value="selectedLabelIds"
        multiple
    >
        <SelectTrigger
            class="m-0 border-none p-0 dark:bg-background"
            :show-chevron="false"
        >
            <TooltipButton :icon="Tag" tooltip="Select labels" />
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
</template>
