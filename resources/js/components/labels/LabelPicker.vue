<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
} from '@/components/ui/select';
import type { Label } from '@/types/labels/Label';
import { Tag } from 'lucide-vue-next';
import type { AcceptableValue } from 'reka-ui';

const { labels, modelValue } = defineProps<{
    labels: Label[];
    modelValue: number[];
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: number[]): void;
}>();

const onChange = (val: AcceptableValue): void => {
    emit('update:modelValue', val as number[]);
};
</script>

<template>
    <Select @update:model-value="onChange" :model-value="modelValue" multiple>
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
