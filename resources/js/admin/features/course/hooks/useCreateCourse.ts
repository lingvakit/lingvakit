import { useNavigate } from "react-router-dom";
import {useCallback, useState} from "react";
import {createCourse} from "../api/createCourse";
import type {CreateCoursePayload} from "../types/course";

type UseCreateCourseResult = {
    create: (data: CreateCoursePayload) => Promise<void>;
    isSaving: boolean;
    error: string | null;
};

export function useCreateCourse(): UseCreateCourseResult {
    const navigate = useNavigate();

    const [isSaving, setIsSaving] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const create = useCallback(async (data: CreateCoursePayload): Promise<void> => {
        try {
            setIsSaving(true);
            setError(null);

            const result = await createCourse(data);
            const courseId = result?.data?.id;

            navigate(
                courseId
                    ? `/dashboard/coursesReact/${courseId}`
                    : "/dashboard/coursesReact"
            );
        } catch (error: unknown) {
            setError(
                error instanceof Error ? error.message : "Не удалось сохранить курс"
            );
            throw error;
        } finally {
            setIsSaving(false);
        }
    }, [navigate]);

    return {
        create,
        isSaving,
        error,
    };
}