<script setup lang="ts">
import { Tag } from 'lucide-vue-next';
const { name } = defineProps<{
    name: string;
}>();
</script>

<template>
    <div class="flex items-center gap-3">
        <div>
            <Tag class="size-5 text-muted-foreground" />
        </div>
        <p class="font-medium">{{ name }}</p>
    </div>
</template>
