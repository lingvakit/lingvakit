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

export type ChatResponse = {
    choices: Choice[],
    created: number,
    model: string,
    object: string,
    usage: Usage
};
