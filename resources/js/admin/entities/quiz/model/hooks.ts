import {useParams} from "react-router-dom";
import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {Quiz, QuizStorePayload} from "./types";
import {storeQuiz} from "../api/storeQuiz";

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