<script setup lang="ts">
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';
import { ref } from 'vue';
import { IconAction } from '@/types/ui/IconAction';
import { ChevronRight, Pencil, Trash2 } from 'lucide-vue-next';

const icons = ref<IconAction[]>([
    { tooltip: 'Edit label', icon: Pencil },
    { tooltip: 'Delete label', icon: Trash2, variant: 'destructive' },
    { tooltip: 'View tasks', icon: ChevronRight }
]);
</script>

<template>
    <div class="flex gap-1">
        <TooltipButton
            v-for="icon in icons"
            :key="icon.tooltip"
            :tooltip="icon.tooltip"
            :icon="icon.icon"
            :variant="icon.variant"
        />
    </div>
</template>
