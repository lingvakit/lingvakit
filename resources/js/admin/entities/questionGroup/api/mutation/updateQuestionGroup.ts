import {QuestionGroup, QuestionGroupUpdatePayload} from "../../model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function updateQuestionGroup(
    questionGroupUuid: string,
    data: QuestionGroupUpdatePayload
): Promise<QuestionGroup> {
    return fetchJson<QuestionGroup>(`${baseApiUrl}/questionGroups/${questionGroupUuid}`, {
        method: "PUT",
        body: data,
    });
}