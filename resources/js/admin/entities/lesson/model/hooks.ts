import {useCallback, useState} from "react";
import {LessonStorePayload, LessonResponse, LessonUpdatePayload} from "./types";
import {useNavigate, useParams} from "react-router-dom";
import {storeLesson} from "../../topic/api/mutation/storeLesson";
import {updateLesson} from "../../topic/api/mutation/updateLesson";

type MutationFn<T, R> = (data: T) => Promise<R>;

type Options<T, R> = {
    mutationFn: MutationFn<T, R>;
    onSuccessNavigateTo: string;
    errorMessage: string;
    onSuccess?: (response: R) => void;
};

export function useLessonMutation<T, R>({
    mutationFn,
    onSuccessNavigateTo,
    errorMessage,
    onSuccess,
}: Options<T, R>) {
    const navigate = useNavigate();

    const [isSavingProcess, setIsSavingProcess] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const execute = useCallback(
        async (data: T): Promise<void> => {
            try {
                setIsSavingProcess(true);
                setError(null);

                const response = await mutationFn(data);

                onSuccess?.(response);
                navigate(onSuccessNavigateTo);
            } catch (e: any) {
                setError(
                    e instanceof Error ? e.message : errorMessage
                );
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

export function useCreateLesson() {
    const { courseId } = useParams();

    return useLessonMutation<LessonStorePayload, LessonResponse>({
        mutationFn: storeLesson,
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания урока",
    });
}

export function useUpdateLesson() {
    const {courseId, lessonId} = useParams<{courseId: string, lessonId: string}>();

    if (!lessonId) {
        throw new Error("lessonId is required");
    }

    return useLessonMutation<LessonUpdatePayload, LessonResponse>({
        mutationFn: (data) => updateLesson(Number(lessonId), data),
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка обновления урока"
    });
}
