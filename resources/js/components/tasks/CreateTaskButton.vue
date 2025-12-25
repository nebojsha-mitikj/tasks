<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

const emit = defineEmits<{
    (e: 'create'): void;
}>();
</script>

<template>
    <button
        @click="emit('create')"
        type="button"
        class="fixed right-8 bottom-8 inline-flex h-12 w-12 cursor-pointer items-center justify-center rounded-full bg-primary text-primary-foreground shadow-lg transition hover:bg-primary/90"
    >
        <Plus class="h-6 w-6" />
    </button>
</template>
