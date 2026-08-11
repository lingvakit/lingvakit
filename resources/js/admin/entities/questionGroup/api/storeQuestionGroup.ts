import {QuestionGroup, QuestionGroupPayload} from "../model/types";
import {fetchJson} from "../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../shared/constants/api";

export async function storeQuestionGroup(
    data: QuestionGroupPayload
): Promise<QuestionGroup> {
    return fetchJson<QuestionGroup>(`${baseApiUrl}/questionGroups`, {
        method: "POST",
        body: data,
    });
}
