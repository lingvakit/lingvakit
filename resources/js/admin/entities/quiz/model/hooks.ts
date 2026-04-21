import {useParams} from "react-router-dom";
import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {Quiz, QuizStorePayload, QuizUpdatePayload} from "./types";
import {storeQuiz} from "../api/storeQuiz";
import {updateQuiz} from "../api/updateQuiz";

export function useCreateQuiz() {
    const {courseId} = useParams();

    return useEntityMutation<QuizStorePayload, Quiz>({
        mutationFn: storeQuiz,
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания теста",
    });
}

export function useUpdateQuiz() {
    const {courseId, quizUuid} = useParams<{ courseId: string, quizUuid: string }>();

    if (!quizUuid) {
        throw new Error("quizUuid is required");
    }

    return useEntityMutation<QuizUpdatePayload, Quiz>({
        mutationFn: (data) => updateQuiz(quizUuid, data),
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка обновления теста"
    });
}