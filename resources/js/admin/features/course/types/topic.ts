export type Topic = {
    id: number;
    title: string;
    type: string;
    imageUrl: string;
    sortIndex: number | null;
    requiredTopics?: object | null;
    description?: string | null;
    duration?: number | null;
};
