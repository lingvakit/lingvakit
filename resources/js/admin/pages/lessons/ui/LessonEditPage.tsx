import { useLoaderData } from "react-router-dom";
import { Lesson } from "@admin/entities/lesson/model/types";
import { useUpdateLesson } from "@admin/entities/lesson/model/hooks";
import { LessonFormValues } from "@admin/features/lesson/model/useLessonForm";
import { useCallback } from "react";
import { LessonFormScreen } from "./components/LessonFormScreen";

export function LessonEditPage() {
    const lesson = useLoaderData() as Lesson;
    const { execute, isSavingProcess, error, validationErrors } =
        useUpdateLesson();

    const handleSubmit = useCallback(
        async (fields: LessonFormValues): Promise<void> => {
            await execute(fields);
        },
        [execute],
    );

    return (
        <LessonFormScreen
            title={`${lesson.title} (ред.)`}
            isSaving={isSavingProcess}
            error={error}
            validationErrors={validationErrors}
            initialValues={{
                title: lesson.title,
                description: lesson.description,
                duration: lesson.duration,
                mediaFiles: {
                    audio: lesson.audioFile,
                    image: lesson.imageFile,
                    video: lesson.videoFile,
                },
            }}
            onSubmit={handleSubmit}
        />
    );
}
