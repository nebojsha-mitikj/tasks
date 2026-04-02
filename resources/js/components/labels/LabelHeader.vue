<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

const emit = defineEmits<{
    (e: 'create'): void;
}>();
</script>

<template>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1
                class="text-2xl font-bold tracking-tight text-[#111] dark:text-white"
            >
                Labels
            </h1>
            <p class="mt-1 text-sm text-[#888] dark:text-[#666]">
                Manage and organize your task labels.
            </p>
        </div>
        <button
            @click="emit('create')"
            class="flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-black/[0.1] bg-white px-3 py-1.5 text-sm font-medium text-[#333] shadow-sm transition-colors hover:bg-black/[0.04] sm:w-auto sm:justify-start dark:border-white/[0.1] dark:bg-[#1a1a1a] dark:text-[#ccc] dark:hover:bg-white/[0.06]"
        >
            <Plus class="size-3.5" />
            Add label
        </button>
    </div>
</template>
