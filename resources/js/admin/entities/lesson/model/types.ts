export type LessonStorePayload = {
    moduleId: number;
    title: string;
    duration: number;
    description?: string | null;
    audioMediaId?: number | null;
    imageMediaId?: number | null;
    videoMediaId?: number | null;
};

export type LessonStoreResponse = {
    data: {
        id: number;
        title: string;
        duration: number;
        description: string | null;
        audioMediaId: number | null;
        imageMediaId: number | null;
        videoMediaId: number | null;
        orderIndex: number | null;
    }
};
