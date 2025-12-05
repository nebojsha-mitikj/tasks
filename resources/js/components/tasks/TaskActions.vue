<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Pencil, Trash2 } from 'lucide-vue-next';
</script>

<template>
    <div>
        <Link class="rounded p-1 transition hover:bg-muted">
            <Pencil
                class="h-4 w-4 text-muted-foreground hover:text-foreground"
            />
        </Link>
        <Link
            method="delete"
            as="button"
            preserve-scroll
            class="cursor-pointer rounded p-1 transition hover:bg-destructive/10"
        >
            <Trash2 class="h-4 w-4 text-destructive" />
        </Link>
    </div>
</template>
