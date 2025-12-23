<script setup lang="ts">
import LabelActions from '@/components/labels/LabelActions.vue';
import LabelName from '@/components/labels/LabelName.vue';
import { Label } from '@/types/Label';

const { labels } = defineProps<{ labels: Label[] }>();
</script>

<template>
    <div class="space-y-1">
        <div
            v-for="label in labels"
            :key="label.id"
            class="group flex items-center justify-between rounded-xl px-6 py-2 hover:bg-muted/50"
        >
            <LabelName :name="label.name"/>

            <LabelActions :label="label" />
        </div>
    </div>
</template>
