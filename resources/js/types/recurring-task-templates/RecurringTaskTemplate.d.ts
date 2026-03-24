import type { TaskPriority } from '@/enums/TaskPriority';
import { TaskRecur } from '@/enums/TaskRecur';
import { Weekday } from '@/enums/Weekday';
import { Label } from '@/types/labels/Label';
import { RecurringTaskTemplatePeriod } from '@/types/recurring-task-templates/RecurringTaskTemplatePeriod';

export interface RecurringTaskTemplate {
    readonly id: number;
    readonly user_id: number;
    title: string;
    description: string | null;
    is_active: boolean;
    recur: TaskRecur;
    weekdays?: Weekday[];
    priority: TaskPriority;
    labels: Label[];
    periods: RecurringTaskTemplatePeriod[];
    created_at: string;
    updated_at: string;
}
