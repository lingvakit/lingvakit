import {useCallback, useState} from "react";
import {LessonStorePayload} from "./types";
import {useNavigate, useParams} from "react-router-dom";
import {storeLesson} from "../../topic/api/mutation/storeLesson";

export function useCreateLesson() {
    const navigate = useNavigate();
    const { courseId } = useParams();

    const [isSavingProcess, setIsSavingProcess] = useState<boolean>(false);
    const [error, setError] = useState<string | null>(null);

    const saveLesson = useCallback(
        async (
            data: LessonStorePayload
        ): Promise<void> => {
            try {
                setIsSavingProcess(true);
                setError(null);

                await storeLesson(data);

                navigate(
                    courseId
                        ? `/dashboard/coursesReact/${courseId}`
                        : "/dashboard/coursesReact"
                );

            } catch (error: any) {
                setError(
                    error instanceof Error
                        ? error.message
                        : "Something went wrong with creating lesson"
                );
            } finally {
                setIsSavingProcess(false);
            }
        },
        [navigate]
    );

    return {
        saveLesson,
        isSavingProcess,
        error
    };
}
