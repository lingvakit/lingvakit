import { usePaginatedList } from "../../../shared/hooks/usePagination";
import { Course, CourseCreatePayload, UseCourseCreateResult } from "./types";
import { getCoursesList } from "../api/queries/getCoursesList";
import { useNavigate } from "react-router-dom";
import { useCallback, useState } from "react";
import { createCourse } from "../api/mutation/createCourse";

export function useCoursesList() {
    return usePaginatedList<Course>({
        fetcher: getCoursesList
    });
}

export function useCreateCourse(): UseCourseCreateResult {
    const navigate = useNavigate();

    const [isSaving, setIsSaving] = useState(false);
    const [error, setError] = useState<string | null>(null);
    const [fieldErrors, setFieldErrors] = useState<Record<string, string[]>>({});

    const create = useCallback(async (data: CourseCreatePayload): Promise<void> => {
        try {
            setIsSaving(true);
            setError(null);
            setFieldErrors({});

            const result = await createCourse(data);
            const courseId = result?.data?.id;

            navigate(
                courseId
                    ? `/dashboard/coursesReact/${courseId}`
                    : "/dashboard/coursesReact"
            );
        } catch (error: any) {
            if (error?.status === 422) {
                setFieldErrors(error.errors || {});
                return;
            } else {
                setError(
                    error instanceof Error ? error.message : "Не удалось сохранить курс"
                );
            }

            throw error;
        } finally {
            setIsSaving(false);
        }
    }, [navigate]);

    return {
        create,
        isSaving,
        error,
        fieldErrors
    };
}