<script setup lang="ts">
import { Plus } from 'lucide-vue-next';
import TooltipButton from '@/components/ui-custom/TooltipButton.vue';

const emit = defineEmits<{
    (e: 'create'): void;
}>();
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Labels</h1>
                <p class="text-sm text-muted-foreground">
                    <span>Manage and organize your task labels.</span>
                </p>
            </div>
        </div>
        <TooltipButton
            @click="emit('create')"
            :icon="Plus"
            tooltip="Add label"
        />
    </div>
</template>
