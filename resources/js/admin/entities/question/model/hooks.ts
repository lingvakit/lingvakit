import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {QuestionAnswerPayload} from "../../questionAnswer/model/types"
import {Question} from "./types";
import {patchQuestionAnswer} from "../api/mutation/patchQuestionAnswer";

export interface PatchQuestionAnswerVariables {
    questionUuid: string;
    payload: QuestionAnswerPayload;
}

export function usePatchQuestionAnswer() {
    return useEntityMutation<PatchQuestionAnswerVariables, Question>({
        mutationFn: ({ questionUuid, payload }) => patchQuestionAnswer(questionUuid, payload),
        errorMessage: "Ошибка обновления ответа",
    });
}
