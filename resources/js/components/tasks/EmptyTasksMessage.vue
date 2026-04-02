<script setup lang="ts">
const { title, subtitle = "You're all caught up for now." } = defineProps<{
    title: string;
    subtitle?: string;
}>();
</script>

<template>
    <div class="mx-auto my-8 w-full max-w-4xl">
        <div
            class="rounded-xl border border-black/[0.07] bg-white px-6 py-12 text-center shadow-sm dark:border-white/[0.07] dark:bg-[#111]"
        >
            <p class="text-[15px] font-semibold text-[#111] dark:text-white">
                {{ title }}
            </p>
            <p class="mt-1 text-sm text-[#999] dark:text-[#666]">
                {{ subtitle }}
            </p>
        </div>
    </div>
</template>
