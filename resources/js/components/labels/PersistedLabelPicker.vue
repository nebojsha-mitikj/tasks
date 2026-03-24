<script setup lang="ts">
import LabelPicker from '@/components/labels/LabelPicker.vue';
import type { Label } from '@/types/labels/Label';
import { RouteDefinition } from '@/wayfinder';
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const { labels, selected, updateUrl } = defineProps<{
    labels: Label[];
    selected: Label[];
    updateUrl: RouteDefinition<'put'>;
}>();

const selectedLabelIds = ref<number[]>(selected.map((l) => l.id));

watch(
    () => selected,
    (selected) => {
        selectedLabelIds.value = selected.map((l) => l.id);
    },
);

const save = (ids: number[]): void => {
    selectedLabelIds.value = ids;
    router.put(
        updateUrl,
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
