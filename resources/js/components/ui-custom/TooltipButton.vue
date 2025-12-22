<script setup lang="ts">
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import { Button } from '@/components/ui/button';
import type { Component } from 'vue';

const { icon, tooltip, variant = 'default' } = defineProps<{
    icon: Component,
    tooltip?: string
    variant?: 'default' | 'destructive',
    disabled?: boolean
}>();

const emit = defineEmits<{
    (e: 'click'): void
}>();
</script>

<template>
    <Tooltip>
        <TooltipTrigger as-child>
            <Button
                :disabled="disabled"
                size="icon"
                variant="ghost"
                class="cursor-pointer rounded-full"
                @click="emit('click')"
            >
                <component
                    :is="icon"
                    class="size-5"
                    :class="{
                        'text-muted-foreground': variant === 'default',
                        'text-destructive': variant === 'destructive'
                    }"
                />
            </Button>
        </TooltipTrigger>

        <TooltipContent v-if="tooltip">
            {{ tooltip }}
        </TooltipContent>
    </Tooltip>
</template>
