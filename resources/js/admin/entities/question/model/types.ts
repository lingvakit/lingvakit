import {QuestionOption, QuestionOptionPayload} from "../../questionOption/model/types";
import {QuestionAnswer, QuestionAnswerPayload} from "../../questionAnswer/model/types";

export type QuestionType = "single_choice" | "multiple_choice" | "boolean" | "fill_in_blank" | "match" | "sentence_build" | "free_text";

export type Question = {
    uuid: string,
    text: string,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    type: QuestionType,
    settings?: {} | null,
    options: QuestionOption[]
    answer: QuestionAnswer,
};

export type QuestionPayload = {
    uuid: string,
    text: string,
    type: QuestionType,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    settings?: {} | null,
    answer: QuestionAnswerPayload,
    options: QuestionOptionPayload[]
};