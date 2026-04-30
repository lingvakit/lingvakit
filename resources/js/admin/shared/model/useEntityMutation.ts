import {useNavigate} from "react-router-dom";
import {useCallback, useState} from "react";

type MutationFn<T, R> = (data: T) => Promise<R>;

type Options<T, R> = {
    mutationFn: MutationFn<T, R>;
    onSuccessNavigateTo?: string;
    errorMessage: string;
    onSuccess?: (response: R) => void;
};

export function useEntityMutation<T, R>({
    mutationFn,
    onSuccessNavigateTo,
    errorMessage,
    onSuccess,
}: Options<T, R>) {
    const navigate = useNavigate();

    const [isSavingProcess, setIsSavingProcess] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const execute = useCallback(
        async (data: T): Promise<R | null> => {
            try {
                setIsSavingProcess(true);
                setError(null);

                const response = await mutationFn(data);

                onSuccess?.(response);

                if (onSuccessNavigateTo) {
                    navigate(onSuccessNavigateTo);
                }

                return response;
            } catch (e: any) {
                setError(
                    e instanceof Error ? e.message : errorMessage
                );

                return null;
            } finally {
                setIsSavingProcess(false);
            }
        },
        [mutationFn, navigate, onSuccessNavigateTo]
    );

    return {
        execute,
        isSavingProcess,
        error,
    };
}
