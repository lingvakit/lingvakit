import {MediaFile} from "../../media/model/types";

type QuizStatuses = "deleted" | "draft" | "published";

export type Quiz = {
    uuid: string;
    title: string;
    description: string | null;
    audioFile: MediaFile|null;
    imageFile: MediaFile;
    videoFile: MediaFile|null;
    timeLimit: number;
    passingScore: number;
    status: QuizStatuses;
};

export type QuizStorePayload = {
    moduleId: number;
    uuid: string;
    title: string;
    description?: string | null;
    audioMediaId?: number | null;
    imageMediaId?: number | null;
    videoMediaId?: number | null;
    timeLimit?: number | null;
    passingScore: number;
    status: QuizStatuses;
};
