import type { TaskPriority } from '@/enums/TaskPriority'

export interface CreateTaskPayload {
    title: string;
    description: string | null;
    date: string;
    priority: TaskPriority;
    label_ids: number[];
}
