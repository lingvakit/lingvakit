import {MediaFile} from "../../media/model/types";
import {QuestionGroup} from "../../questionGroup/model/types";

type QuizStatuses = "deleted" | "draft" | "published";

export type Quiz = {
    uuid: string,
    title: string,
    description: string,
    audioFile: MediaFile|null,
    imageFile: MediaFile,
    videoFile: MediaFile|null,
    timeLimit: number,
    passingScore: number,
    orderIndex: number|null,
    status: QuizStatuses,
    questionGroups: QuestionGroup[],
};

export type QuizStorePayload = {
    moduleId: number,
    uuid: string,
    title: string,
    description?: string|null,
    audioMediaId?: number|null,
    imageMediaId?: number|null,
    videoMediaId?: number|null,
    timeLimit?: number|null,
    passingScore: number,
    status: QuizStatuses,
};

export type QuizUpdatePayload = {
    title?: string;
    description?: string|null,
    audioMediaId?: number|null,
    imageMediaId?: number|null,
    videoMediaId?: number|null,
    timeLimit?: number|null,
    passingScore?: number,
    status?: QuizStatuses,
};
