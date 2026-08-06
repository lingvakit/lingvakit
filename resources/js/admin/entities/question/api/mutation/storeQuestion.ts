import {Question, QuestionPayload} from "../../model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function storeQuestion(
    payload: QuestionPayload
): Promise<Question> {
    return fetchJson<Question>(
        `${baseApiUrl}/questions`,
        {
            method: "POST",
            body: payload,
        }
    );
}
