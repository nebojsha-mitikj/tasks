<script setup lang="ts">
import LabelActions from '@/components/labels/LabelActions.vue';
import LabelName from '@/components/labels/LabelName.vue';
import type { Label } from '@/types/labels/Label';

const { labels } = defineProps<{ labels: Label[] }>();

const emit = defineEmits<{
    (e: 'edit', label: Label): void
}>();

</script>

<template>
    <div class="space-y-1">
        <div
            v-for="label in labels"
            :key="label.id"
            class="group flex items-center justify-between rounded-xl px-6 py-2 hover:bg-muted/50"
        >
            <LabelName :name="label.name"/>

            <LabelActions @edit="emit('edit', $event)" :label="label" />
        </div>
    </div>
</template>
