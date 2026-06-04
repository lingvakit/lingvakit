import {useCallback, useState} from "react";
import {AiChatPayload} from "./types";
import {generateChatCompletions} from "../api/generateChatCompletions";

type UseAiGenerateMessageReturn = {
    execute: (payload: AiChatPayload) => Promise<string|null>,
    isProcessing: boolean,
    error: string|null,
};

export function useAiGenerateMessage(): UseAiGenerateMessageReturn {
    const [isProcessing, setIsProcessing] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const execute = useCallback(
        async (
            payload: AiChatPayload
        ): Promise<string|null> => {
            try {
                setIsProcessing(true);
                setError(null);

                const response = await generateChatCompletions(payload);

                return response.choices?.[0].message.content;
            } catch (error: unknown) {
                setError(
                    error instanceof Error
                        ? error.message
                        : 'Не удалось сгенерировать ответ.'
                );

                return null;
            } finally {
                setIsProcessing(false);
            }
        },
        []
    );

    return {
        execute,
        isProcessing,
        error
    };
}
