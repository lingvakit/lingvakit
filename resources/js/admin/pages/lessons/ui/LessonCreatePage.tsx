import { useCreateLesson } from "@admin/entities/lesson/model/hooks";
import { Navigate, useParams } from "react-router-dom";
import { LessonFormValues } from "@admin/features/lesson/model/useLessonForm";
import { LessonFormScreen } from "./components/LessonFormScreen";
import { useCallback } from "react";
import { buildLessonPayload } from "@admin/features/lesson/lib/buildLessonPayload";

export default function LessonCreatePage() {
    const { moduleId: moduleIdParam } = useParams();
    const { execute, isSavingProcess, error, validationErrors } =
        useCreateLesson();

    const moduleId = /^[1-9]\d*$/.test(moduleIdParam ?? "")
        ? Number(moduleIdParam)
        : null;

    const handleSubmit = useCallback(
        async (fields: LessonFormValues): Promise<void> => {
            if (moduleId === null) return;

            await execute({
                ...buildLessonPayload(fields),
                moduleId,
            });
        },
        [execute, moduleId],
    );

    if (moduleId === null) {
        return <Navigate to="/" replace />;
    }

    return (
        <LessonFormScreen
            title="Новый урок"
            isSaving={isSavingProcess}
            error={error}
            validationErrors={validationErrors}
            onSubmit={handleSubmit}
        />
    );
}
