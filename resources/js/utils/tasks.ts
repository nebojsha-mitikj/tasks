import { TaskStatus } from '@/enums/TaskStatus';

const statusLabelMap: Record<TaskStatus, string> = {
    [TaskStatus.COMPLETED]: 'Completed',
    [TaskStatus.IN_PROGRESS]: 'In progress',
    [TaskStatus.TO_DO]: 'To do',
};

const statusClassMap: Record<TaskStatus, string> = {
    [TaskStatus.COMPLETED]: 'text-emerald-600 dark:text-emerald-500',
    [TaskStatus.IN_PROGRESS]: 'text-amber-600 dark:text-amber-500',
    [TaskStatus.TO_DO]: 'text-sky-600 dark:text-sky-500',
};

export const statusLabel = (status: TaskStatus): string =>
    statusLabelMap[status];

export const statusClass = (status: TaskStatus): string =>
    statusClassMap[status];
