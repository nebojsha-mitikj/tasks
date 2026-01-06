<script setup lang="ts">
import LabelPicker from '@/components/labels/LabelPicker.vue';
import type { Label } from '@/types/labels/Label';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { RouteDefinition } from '@/wayfinder';

const props = defineProps<{
    labels: Label[];
    selected: Label[];
    updateUrl: RouteDefinition<'put'>;
}>();

const selectedLabelIds = ref<number[]>(
    (props.selected ?? []).map((l) => l.id),
);

watch(
    () => props.selected,
    (selected) => {
        selectedLabelIds.value = (selected ?? []).map((l) => l.id);
    },
);

const save = (ids: number[]): void => {
    selectedLabelIds.value = ids;
    router.put(
        props.updateUrl,
        { label_ids: selectedLabelIds.value },
        {
            preserveScroll: true,
            preserveState: true,
        },
    );
};
</script>

<template>
    <LabelPicker
        :labels="labels"
        :model-value="selectedLabelIds"
        @update:model-value="save"
    />
</template>
