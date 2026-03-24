<script setup lang="ts">
const { text } = defineProps<{ text?: string | null }>();
</script>

<template>
    <p v-if="text != null && text !== ''" class="text-xs text-muted-foreground whitespace-pre-wrap">
        {{ text }}
    </p>
</template>
