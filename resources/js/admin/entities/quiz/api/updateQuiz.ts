import {baseApiUrl} from "../../../shared/constants/api";
import {fetchJson} from "../../../shared/api/fetchJson";
import {Quiz, QuizUpdatePayload} from "../model/types";

export function updateQuiz(
    quizUuid: string,
    data: QuizUpdatePayload,
): Promise<Quiz> {
    const updateQuizEndpoint = `${baseApiUrl}/quizzes/${quizUuid}`;

    return fetchJson<Quiz>(updateQuizEndpoint, {
        method: "PUT",
        body: data,
    });
}
