import { useNavigate } from "react-router-dom";
import { useState } from "react";
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

    const create = async (data: CreateCoursePayload): Promise<void> => {
        try {
            setIsSaving(true);
            setError(null);

            const json = await createCourse(data);
            const courseId = json?.data?.id;

            if (courseId) {
                navigate(`/dashboard/coursesReact/${courseId}`);
                return;
            }

            navigate("/dashboard/coursesReact");
        } catch (error: unknown) {
            const message =
                error instanceof Error ? error.message : "Не удалось сохранить курс";

            setError(message);
            console.error("Ошибка при сохранении курса", error);
            throw error;
        } finally {
            setIsSaving(false);
        }
    };

    return {
        create,
        isSaving,
        error,
    };
}