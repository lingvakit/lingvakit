import {Quiz, QuizStorePayload} from "../model/types";
import {fetchJson} from "../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../shared/constants/api";

export async function storeQuiz(
    data: QuizStorePayload
): Promise<Quiz> {
    const storeQuizEndpoint = `${baseApiUrl}/quizzes`;

    return fetchJson<Quiz>(storeQuizEndpoint, {
        method: "POST",
        body: data,
    });
}
