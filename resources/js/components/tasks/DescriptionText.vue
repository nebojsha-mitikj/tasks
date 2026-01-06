<script setup lang="ts">
const { text } = defineProps<{ text?: string | null }>();
</script>

<template>
    <p v-if="text" class="text-xs text-muted-foreground">
        {{ text }}
    </p>
</template>
