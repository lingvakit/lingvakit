import {AiChatPayload, AiChatResponseDto} from "../model/types";
import {fetchJson} from "../../../shared/api/fetchJson";

export async function generateChatCompletions(
    payload: AiChatPayload
): Promise<AiChatResponseDto> {
    const endpoint = "/ms/ai/api/v1/chat";

    return fetchJson<AiChatResponseDto>(endpoint, {
        method: "POST",
        body: payload,
    });
}
