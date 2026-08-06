import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {QuestionAnswerPayload} from "../../questionAnswer/model/types"
import {Question, QuestionPayload} from "./types";
import {patchQuestionAnswer} from "../api/mutation/patchQuestionAnswer";
import {storeQuestion} from "../api/mutation/storeQuestion";

export interface PatchQuestionAnswerVariables {
    questionUuid: string;
    payload: QuestionAnswerPayload;
}

export function useCreateQuestion() {
    return useEntityMutation<QuestionPayload, Question>({
        mutationFn: storeQuestion,
        errorMessage: "Ошибка создания вопроса",
    });
}

export function usePatchQuestionAnswer() {
    return useEntityMutation<PatchQuestionAnswerVariables, Question>({
        mutationFn: ({ questionUuid, payload }) => patchQuestionAnswer(questionUuid, payload),
        errorMessage: "Ошибка обновления ответа",
    });
}
