import { useCallback } from "react";
import { useLoaderData } from "react-router-dom";
import { QuizFormScreen } from "./components/QuizFormScreen";
import { useUpdateQuiz } from "@admin/entities/quiz/model/hooks";
import type { Quiz } from "@admin/entities/quiz/model/types";
import { QuizFormValues } from "@admin/features/quiz/model/useQuizForm";

export function QuizEditPage() {
    const quiz = useLoaderData() as Quiz;
    const { execute, isSavingProcess, error, validationErrors } =
        useUpdateQuiz();

    const handleSubmit = useCallback(
        async (fields: QuizFormValues): Promise<void> => {
            await execute(fields);
        },
        [execute],
    );

    return (
        <QuizFormScreen
            key={quiz.uuid}
            title={`${quiz.title} (ред.)`}
            isSaving={isSavingProcess}
            error={error}
            validationErrors={validationErrors}
            initialValues={{
                categoryId: quiz.categoryId,
                title: quiz.title,
                description: quiz.description,
                timeLimit: quiz.timeLimit,
                passingScore: quiz.passingScore,
                mediaFiles: {
                    audio: quiz.audioFile,
                    image: quiz.imageFile,
                    video: quiz.videoFile,
                },
            }}
            onSubmit={handleSubmit}
        />
    );
}
