import {QuestionOptionPayload} from "../../questionOption/model/types";

export type QuestionType = "single_choice" | "multiple_choice";

export type QuestionPayload = {
    text: string,
    type: QuestionType,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    settings?: {} | null,
    answer: {
        type: QuestionType,
        value: string,
    },
    options: QuestionOptionPayload[]
};