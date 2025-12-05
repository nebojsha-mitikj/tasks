import type { TaskStatus } from '@/enums/TaskStatus';
import type { TaskPriority } from '@/enums/TaskPriority';

export interface Task {
    id: number;
    user_id: number;
    recurring_task_template_id: number | null,
    title: string;
    description: string | null;
    date: string;
    status: TaskStatus;
    priority: TaskPriority;
    created_at: string;
    updated_at: string;
}
