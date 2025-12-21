import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function usePageMatch(componentName: string) {
    const page = usePage();
    const isMatch = computed(() => page.component === componentName);
    return { isMatch };
}
