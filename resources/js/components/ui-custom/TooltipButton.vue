<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip';
import type { Component } from 'vue';

const props = withDefaults(
    defineProps<{
        icon: Component;
        tooltip?: string;
        variant?: 'default' | 'destructive';
        disabled?: boolean;
    }>(),
    {
        variant: 'default',
        disabled: false,
    },
);
</script>

<template>
    <Tooltip>
        <TooltipTrigger as-child>
            <Button
                v-bind="$attrs"
                :disabled="props.disabled"
                size="icon"
                variant="ghost"
                class="cursor-pointer rounded-full"
            >
                <component
                    :is="props.icon"
                    class="size-5"
                    :class="
                        props.variant === 'destructive'
                            ? 'text-destructive'
                            : 'text-muted-foreground'
                    "
                />
            </Button>
        </TooltipTrigger>

        <TooltipContent v-if="props.tooltip">
            {{ props.tooltip }}
        </TooltipContent>
    </Tooltip>
</template>

<style>
.tooltip-trigger svg {
    display: none;
}
</style>
