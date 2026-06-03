import {AiChatPayload, AiChatResponse} from "../model/types";
import {fetchJson} from "../../../shared/api/fetchJson";

export async function generateChatCompletions(
    payload: AiChatPayload
): Promise<AiChatResponse> {
    const endpoint = "/ms/ai/api/v1/chat";

    return fetchJson<AiChatResponse>(endpoint, {
        method: "POST",
        body: payload,
    });
}
