type Role = "assistant" | "system" | "user";

type Usage = {
    promptTokens: number,
    completionTokens: number,
    totalTokens: number,
    precachedPromptTokens: number
};

type Choice = {
    message: Message,
    index: number,
    finishReason: string
};

export type Message = {
    content: string,
    role: Role,
};

export type AiChatPayload = {
    messages: Message[],
}

export type AiChatResponse = {
    choices: Choice[],
    created: number,
    model: string,
    object: string,
    usage: Usage
};

export type UseAiGenerateQuestions = {
    execute: (
        payload: AiChatPayload
    ) => Promise<string | null>,
    isProcessing: boolean,
    error: string | null,
};
