import type { LucideIcon } from 'lucide-vue-next';

export interface IconAction {
    tooltip: string;
    icon: LucideIcon;
    variant?: 'default' | 'destructive';
    action: 'edit' | 'delete' | 'view';
}
