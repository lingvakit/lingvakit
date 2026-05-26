import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {QuestionGroup, QuestionGroupPayload} from "./types";
import {storeQuestionGroup} from "../api/storeQuestionGroup";
import {useParams} from "react-router-dom";

export function useCreateQuestionGroup() {
    const {
        courseId,
        moduleId,
        quizUuid
    } = useParams();

    return useEntityMutation<QuestionGroupPayload, QuestionGroup>({
        mutationFn: storeQuestionGroup,
        onSuccessNavigateTo: courseId && moduleId && quizUuid
            ? `/dashboard/coursesReact/${courseId}/modules/${moduleId}/quizzes/${quizUuid}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания группы вопросов",
    });
}
