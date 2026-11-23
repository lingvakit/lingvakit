import { useCallback, useState } from "react";
import { Navigate, useParams } from "react-router-dom";
import { QuizFormScreen } from "../../shared/ui/QuizFormScreen";
import { useCreateQuiz } from "../../../../entities/quiz/model/hooks";
import { buildQuizPayload } from "../../../../features/quiz/lib/buildQuizPayload";
import type { QuizFormFields } from "../../../../features/quiz/lib/buildQuizPayload";

export function QuizCreatePage() {
    const { moduleId: moduleIdParam } = useParams();
    const { execute, isSavingProcess, error } = useCreateQuiz();

    const [quizUuid] = useState<string>(() => crypto.randomUUID());

    const moduleId = /^[1-9]\d*$/.test(moduleIdParam ?? "")
        ? Number(moduleIdParam)
        : null;

    const handleSubmit = useCallback(
        async (fields: QuizFormFields): Promise<void> => {
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
            onSubmit={handleSubmit}
        />
    );
}
