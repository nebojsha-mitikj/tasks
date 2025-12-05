import { TaskStatus } from '@/enums/TaskStatus';

const statusLabelMap: Record<TaskStatus, string> = {
    [TaskStatus.COMPLETED]: 'Completed',
    [TaskStatus.IN_PROGRESS]: 'In progress',
    [TaskStatus.TO_DO]: 'To do',
};

const statusClassMap: Record<TaskStatus, string> = {
    [TaskStatus.COMPLETED]: 'text-green-600',
    [TaskStatus.IN_PROGRESS]: 'text-orange-600',
    [TaskStatus.TO_DO]: 'text-yellow-600',
};

export const statusLabel = (status: TaskStatus): string => statusLabelMap[status];

export const statusClass = (status: TaskStatus): string => statusClassMap[status];
