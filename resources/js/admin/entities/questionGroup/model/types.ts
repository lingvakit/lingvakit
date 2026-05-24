import {QuestionPayload, QuestionType} from "../../question/model/types";

/* TODO: Remove this */
export type QuestionGroupPayload = {
    uuid: string,
    quizUuid: string,
    title: string,
    questionType: QuestionType,
    description?: string | null,
    orderIndex?: number | null,
    meta?: {
        fontSize?: number,
    },
    questions: QuestionPayload[],
}