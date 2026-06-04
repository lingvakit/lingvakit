import {MediaFile} from "../../media/model/types";

// TODO: Sync level with backend
export type DifficultyLevel = "hsk1" | "hsk2" | "hsk3" | "hard";

export type Lesson = {
    id: number;
    title: string;
    duration: number;
    description: string;
    audioFile: MediaFile|null;
    imageFile: MediaFile;
    videoFile: MediaFile|null;
};

export type LessonResponse = {
    data: Lesson
};

export type LessonStorePayload = {
    moduleId: number;
    title: string;
    duration: number;
    description?: string | null;
    audioMediaId?: number | null;
    imageMediaId?: number | null;
    videoMediaId?: number | null;
};

export type LessonUpdatePayload = {
    title?: string;
    duration?: number;
    description?: string | null;
    audioMediaId?: number | null;
    imageMediaId?: number | null;
    videoMediaId?: number | null;
};
