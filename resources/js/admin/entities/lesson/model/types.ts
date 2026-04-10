import {MediaFile} from "../../media/model/types";

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
