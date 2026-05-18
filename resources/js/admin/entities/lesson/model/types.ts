import {MediaFile} from "../../media/model/types";
import {Message} from "../../ai/model/types";

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

export type AiLessonGeneratePayload = {
    messages: Message[]
};

export type UseAiLessonGeneratedResult = {
    execute: (
        payload: AiLessonGeneratePayload
    ) => Promise<string | null>,
    isProcessing: boolean,
    error: string | null,
};
