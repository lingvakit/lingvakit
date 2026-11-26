import { useCallback, useState } from "react";
import { Navigate, useParams } from "react-router-dom";
import { QuizFormScreen } from "./components/QuizFormScreen";
import { useCreateQuiz } from "@admin/entities/quiz/model/hooks";
import { buildQuizPayload } from "@admin/features/quiz/lib/buildQuizPayload";
import { QuizFormValues } from "@admin/features/quiz/model/useQuizForm";

export function QuizCreatePage() {
    const { moduleId: moduleIdParam } = useParams();
    const { execute, isSavingProcess, error, validationErrors } =
        useCreateQuiz();

    const [quizUuid] = useState<string>(() => crypto.randomUUID());

    const moduleId = /^[1-9]\d*$/.test(moduleIdParam ?? "")
        ? Number(moduleIdParam)
        : null;

    const handleSubmit = useCallback(
        async (fields: QuizFormValues): Promise<void> => {
            if (moduleId === null) return;

            await execute({
                ...buildQuizPayload(fields),
                moduleId,
                uuid: quizUuid,
                status: "draft",
            });
        },
        [execute, moduleId, quizUuid],
    );

    if (moduleId === null) {
        return <Navigate to="/" replace />;
    }

    return (
        <QuizFormScreen
            title="Новый тест"
            isSaving={isSavingProcess}
            error={error}
            validationErrors={validationErrors}
            onSubmit={handleSubmit}
        />
    );
}
