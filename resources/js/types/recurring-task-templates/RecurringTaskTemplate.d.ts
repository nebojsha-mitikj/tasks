import type { TaskPriority } from '@/enums/TaskPriority';
import { TaskRecurEnum } from '@/enums/TaskRecurEnum';
import { Label } from '@/types/labels/Label';
import { RecurringTaskTemplatePeriod } from '@/types/recurring-task-templates/RecurringTaskTemplatePeriod';

export interface RecurringTaskTemplate {
    readonly id: number;
    readonly user_id: number;
    title: string;
    description: string | null;
    recur: TaskRecurEnum;
    priority: TaskPriority;
    labels: Label[];
    periods: RecurringTaskTemplatePeriod[];
    created_at: string;
    updated_at: string;
}
