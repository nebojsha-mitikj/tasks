<script setup lang="ts">
import { show } from '@/routes/labels';
import { Link } from '@inertiajs/vue3';
import { Tag } from 'lucide-vue-next';

const { id, name } = defineProps<{
    id: number;
    name: string;
}>();
</script>

<template>
    <Link :href="show(id)" class="flex cursor-pointer items-center gap-3 transition-opacity hover:opacity-75">
        <span class="flex size-8 flex-shrink-0 items-center justify-center rounded-lg bg-black/[0.05] text-[#888] dark:bg-white/[0.06] dark:text-[#666]">
            <Tag class="size-3.5" />
        </span>
        <p class="text-[15px] font-medium text-[#111] dark:text-white">{{ name }}</p>
    </Link>
</template>
