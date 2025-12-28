<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue'
import type { AcceptableValue } from 'reka-ui'
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger } from '@/components/ui/select'
import { Tag } from 'lucide-vue-next'
import type { Task } from '@/types/tasks/Task'
import type { Label } from '@/types/labels/Label'
import { ref, watch } from 'vue'

const props = defineProps<{ task: Task; labels: Label[] }>();

const emit = defineEmits<{
    (e: 'update:labels', labelIds: number[]): void
}>()

const selectedLabelIds = ref<number[]>([]);

const setFromTask = () => {
    selectedLabelIds.value = (props.task.labels ?? []).map(l => l.id)
};

watch(() => props.task.id, setFromTask, { immediate: true })

const normalizeToNumberArray = (val: AcceptableValue): number[] => {
    if (!Array.isArray(val)) return [];
    return val
        .map(v => Number(v))
        .filter(n => Number.isFinite(n));
}

const onLabelsChange = (val: AcceptableValue): void => {
    const ids = normalizeToNumberArray(val);
    selectedLabelIds.value = ids;
    emit('update:labels', ids);
}
</script>

<template>
    <Select
        @update:model-value="onLabelsChange"
        :model-value="selectedLabelIds"
        multiple
    >
        <SelectTrigger :show-chevron="false" as-child>
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
