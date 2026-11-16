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
    const [validationErrors, setValidationErrors] = useState<Record<string, string[]> | undefined>(undefined);

    const execute = useCallback(
        async (data: T): Promise<R | null> => {
            try {
                setIsSavingProcess(true);
                setError(null);
                setValidationErrors(undefined);

                const response = await mutationFn(data);

                onSuccess?.(response);

                if (onSuccessNavigateTo) {
                    navigate(onSuccessNavigateTo);
                }

                return response;
            }catch (e: any) {
                if (e?.response?.status === 422 && e?.response?.data?.errors) {
                    setValidationErrors(e.response.data.errors);
                    setError("Пожалуйста, проверьте правильность заполнения формы.");
                } else {
                    setError(e instanceof Error ? e.message : errorMessage);
                }

                return null;
            } finally {
                setIsSavingProcess(false);
            }
        },
        [
            mutationFn,
            navigate,
            onSuccessNavigateTo,
            errorMessage,
            onSuccess
        ]
    );

    return {
        execute,
        isSavingProcess,
        error,
        validationErrors,
    };
}
