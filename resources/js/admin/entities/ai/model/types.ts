type AiRole = "assistant" | "system" | "user";

type AiUsage = {
    promptTokens: number,
    completionTokens: number,
    totalTokens: number,
    precachedPromptTokens: number
};

export type AiMessage = {
    content: string,
    role: AiRole,
};

type AiChoice = {
    message: AiMessage,
    index: number,
    finishReason: string
};

export type AiChatPayload = {
    messages: AiMessage[],
};

export type AiChatResponseDto = {
    choices: AiChoice[],
    created: number,
    model: string,
    object: string,
    usage: AiUsage
};
