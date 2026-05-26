import {Question, QuestionPayload, QuestionType} from "../../question/model/types";
import {FontSize} from "../../../features/questionGroup/model/types";

export type QuestionGroup = {
    uuid: string,
    title: string,
    questionType: QuestionType,
    description: string | null,
    orderIndex: number | null,
    meta: {
        fontSize?: FontSize
    } | null,
    questions: Question[],
};

export type QuestionGroupPayload = {
    uuid: string,
    quizUuid: string,
    title: string,
    questionType: QuestionType,
    description?: string | null,
    orderIndex?: number | null,
    meta?: {
        fontSize?: FontSize,
    },
    questions: QuestionPayload[],
}