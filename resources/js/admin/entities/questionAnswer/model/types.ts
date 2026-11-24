import { QuestionType } from "@admin/entities/question/model/types";

export type QuestionAnswer = {
    questionType: QuestionType;
    value: any;
};

export type QuestionAnswerPayload = QuestionAnswer;
