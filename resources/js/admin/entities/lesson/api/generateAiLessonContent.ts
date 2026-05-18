import {fetchJson} from "../../../shared/api/fetchJson";
import {AiLessonGeneratePayload} from "../model/types";
import {ChatResponse} from "../../ai/model/types";

export async function generateAiLessonContent(
    payload: AiLessonGeneratePayload
): Promise<ChatResponse> {
    return fetchJson<ChatResponse>(
        `/ms/ai/api/v1/chat`,
        {
            method: "POST",
            body: payload,
        }
    );
}
