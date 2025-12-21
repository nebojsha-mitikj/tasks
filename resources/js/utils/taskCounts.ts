import { Task } from '@/types/tasks/Task';
import { TaskStatus } from '@/enums/TaskStatus';

export const countCompleted = (tasks: Task[]): number => {
    return tasks.filter(t => t.status === TaskStatus.COMPLETED).length;
}
