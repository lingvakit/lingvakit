import {QuestionOption, QuestionOptionPayload} from "../../questionOption/model/types";

export type QuestionType = "single_choice" | "multiple_choice";

export type Question = {
    uuid: string,
    text: string,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    type: QuestionType,
    settings?: {} | null,
    options: QuestionOption[]
    answer: {
        type: QuestionType,
        value: string[],
    },
};

export type QuestionPayload = {
    uuid: string,
    text: string,
    type: QuestionType,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    settings?: {} | null,
    answer: {
        type: QuestionType,
        value: string[],
    },
    options: QuestionOptionPayload[]
};