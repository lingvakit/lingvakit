import { QuestionGroup, QuestionGroupUpdatePayload } from "../../model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function updateQuestionGroup(
    questionGroupUuid: string,
    data: QuestionGroupUpdatePayload,
): Promise<QuestionGroup> {
    return fetchJson<QuestionGroup>(
        `${baseApiUrl}/questionGroups/${questionGroupUuid}`,
        {
            method: "PUT",
            body: data,
        },
    );
}
