<script setup lang="ts">
const props = defineProps<{
    title: string;
    subtitle?: string;
}>();
</script>

<template>
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">
            {{ props.title }}
        </h1>
        <p class="text-sm text-muted-foreground">
            <span>{{ props.subtitle }}</span>
        </p>
    </div>
</template>
