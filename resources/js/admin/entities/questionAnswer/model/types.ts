import {QuestionType} from "../../question/model/types";

export type QuestionAnswer = {
    questionType: QuestionType,
    value: any
};

export type QuestionAnswerPayload = QuestionAnswer;
