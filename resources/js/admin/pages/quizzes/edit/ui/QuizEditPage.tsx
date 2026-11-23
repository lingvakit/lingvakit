import { useCallback } from "react";
import { useLoaderData } from "react-router-dom";
import { QuizFormScreen } from "../../shared/ui/QuizFormScreen";
import { useUpdateQuiz } from "../../../../entities/quiz/model/hooks";
import type { Quiz } from "../../../../entities/quiz/model/types";
import type { QuizFormFields } from "../../../../features/quiz/lib/buildQuizPayload";

export function QuizEditPage() {
    const quiz = useLoaderData() as Quiz;
    const { execute, isSavingProcess, error } = useUpdateQuiz();

    const handleSubmit = useCallback(
        async (fields: QuizFormFields): Promise<void> => {
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
