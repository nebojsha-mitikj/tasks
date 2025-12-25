<script setup lang="ts">
import PageTitle from '@/components/tasks/PageTitle.vue';
const { title, subtitle = "You're all caught up for now." } = defineProps<{
    title: string;
    subtitle?: string;
}>();
</script>

<template>
    <div class="mx-auto my-10 w-full max-w-4xl space-y-6">
        <PageTitle :title="title" :subtitle="subtitle" />
    </div>
</template>
