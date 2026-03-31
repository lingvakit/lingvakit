import {useCallback, useState} from "react";
import {Module, ModuleCreatePayload, UseModuleCreateResult} from "./types";
import {createModule} from "../api/mutation/createModule";

export function useCreateModule(): UseModuleCreateResult {
    const [isSaving, setIsSaving] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const create = useCallback(
        async (
            courseId: number,
            payload: ModuleCreatePayload
        ): Promise<Module | null> => {
            try {
                setIsSaving(true);
                setError(null);

                const result = await createModule(courseId, payload);

                return result.data;
            } catch (error: unknown) {
                setError(
                    error instanceof Error
                        ? error.message
                        : 'Не удалось сохранить модуль.'
                );

                return null;
            } finally {
                setIsSaving(false);
            }
        },
        []
    );

    return {
        create,
        isSaving,
        error
    };
}
