import {QuestionAnswerPayload} from "../../../questionAnswer/model/types";
import {Question} from "../../model/types";
import {baseApiUrl} from "../../../../shared/constants/api";
import {fetchJson} from "../../../../shared/api/fetchJson";

export function patchQuestionAnswer(
    questionUuid: string,
    data: QuestionAnswerPayload
): Promise<Question> {
    const patchQuestionAnswerEndpoint = `${baseApiUrl}/questions/${questionUuid}/answer`;

    return fetchJson<Question>(patchQuestionAnswerEndpoint, {
        method: "PATCH",
        body: data,
    });
}
