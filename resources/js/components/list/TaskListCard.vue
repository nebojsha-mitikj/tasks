<script setup lang="ts" generic="T extends { id: number }">
const { items, emptyText } = defineProps<{
    items: T[];
    emptyText: string;
}>();
</script>

<template>
    <div class="rounded-lg border bg-card p-6 shadow-sm">
        <div v-if="items.length" class="space-y-4">
            <div
                v-for="item in items"
                :key="item.id"
                class="flex items-start justify-between gap-4 border-b pb-3 last:border-0 last:pb-0"
            >
                <slot name="row" :item="item" />
            </div>
        </div>

        <div v-else class="text-sm text-muted-foreground">
            {{ emptyText }}
        </div>
    </div>
</template>
