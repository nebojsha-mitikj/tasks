import type { TaskStatus } from '@/enums/TaskStatus';
import type { TaskPriority } from '@/enums/TaskPriority';
import { Label } from '@/types/labels/Label';

export interface Task {
    id: number;
    user_id: number;
    recurring_task_template_id: number | null,
    title: string;
    description: string | null;
    date: string;
    status: TaskStatus;
    priority: TaskPriority;
    labels: Label[];
    created_at: string;
    updated_at: string;
}
