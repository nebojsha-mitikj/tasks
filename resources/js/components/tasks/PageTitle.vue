<script setup lang="ts">
const props = defineProps<{
    title: string;
    subtitle?: string;
}>();
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-[#111] dark:text-white">
            {{ props.title }}
        </h1>
        <p v-if="props.subtitle" class="mt-1 text-sm text-[#888] dark:text-[#666]">
            {{ props.subtitle }}
        </p>
    </div>
</template>
