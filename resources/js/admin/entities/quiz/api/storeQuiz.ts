import { Quiz, QuizStorePayload } from "../model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function storeQuiz(data: QuizStorePayload): Promise<Quiz> {
    const storeQuizEndpoint = `${baseApiUrl}/quizzes`;

    return fetchJson<Quiz>(storeQuizEndpoint, {
        method: "POST",
        body: data,
    });
}
