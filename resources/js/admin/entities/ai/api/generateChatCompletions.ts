import {
    AiChatPayload,
    AiChatResponseDto,
} from "@admin/entities/ai/model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";

export async function generateChatCompletions(
    payload: AiChatPayload,
): Promise<AiChatResponseDto> {
    const endpoint = "/ms/ai/api/v1/chat";

    return fetchJson<AiChatResponseDto>(endpoint, {
        method: "POST",
        body: payload,
    });
}
