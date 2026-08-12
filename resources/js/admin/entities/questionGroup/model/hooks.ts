import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {QuestionGroup, QuestionGroupPayload, QuestionGroupUpdatePayload} from "./types";
import {storeQuestionGroup} from "../api/storeQuestionGroup";
import {useParams} from "react-router-dom";
import {updateQuestionGroup} from "../api/mutation/updateQuestionGroup";

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

export function useUpdateQuestionGroup() {
    const {
        courseId,
        moduleId,
        quizUuid,
        questionGroupUuid
    } = useParams();

    if (!questionGroupUuid) {
        throw new Error("questionGroupUuid is required");
    }

    return useEntityMutation<QuestionGroupUpdatePayload, QuestionGroup>({
        mutationFn: (data) => updateQuestionGroup(questionGroupUuid, data),
        onSuccessNavigateTo: courseId && moduleId && quizUuid
            ? `/dashboard/coursesReact/${courseId}/modules/${moduleId}/quizzes/${quizUuid}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания группы вопросов",
    });
}
