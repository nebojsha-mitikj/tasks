import type { TaskPriority } from '@/enums/TaskPriority';
import { TaskRecur } from '@/enums/TaskRecur';
import { Weekday } from '@/enums/Weekday';

export interface CreateRecurringTaskTemplatePayload {
    title: string;
    description?: string | null;
    recur: TaskRecur;
    weekdays?: Weekday[];
    priority: TaskPriority;
    label_ids: number[];
}
