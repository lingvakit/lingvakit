import {fetchJson} from "../../../shared/api/fetchJson";
import {AiLessonGeneratedResponse, AiLessonGeneratePayload} from "../model/types";

export async function generateAiLessonContent(
    payload: AiLessonGeneratePayload
): Promise<AiLessonGeneratedResponse> {
    return fetchJson<AiLessonGeneratedResponse>(
        `/ms/ai/api/v1/lesson`,
        {
            method: "POST",
            body: payload,
        }
    );
}
