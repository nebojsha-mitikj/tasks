export interface LabelBase {
    id: number;
    user_id: number;
    name: string;
    created_at: string;
    updated_at: string;
}

export interface LabelWithTasks extends LabelBase {
    tasks: Task[];
}

export type Label = LabelBase;
