<script setup lang="ts">
import { Badge } from '@/components/ui/badge';
import { Label } from '@/types/labels/Label';
const { labels } = defineProps<{
    labels: Label[];
}>();
</script>

<template>
    <p v-if="labels.length > 0" class="text-[11px] text-muted-foreground">
        Labels:
        <Badge
            variant="secondary"
            v-for="label in labels"
            :key="label.id"
            class="ml-2 font-bold"
        >
            {{ label.name }}
        </Badge>
    </p>
</template>
