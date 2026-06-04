import {
    LessonStorePayload,
    LessonResponse,
    LessonUpdatePayload
} from "./types";
import {useParams} from "react-router-dom";
import {storeLesson} from "../../topic/api/mutation/storeLesson";
import {updateLesson} from "../../topic/api/mutation/updateLesson";
import {deleteLesson} from "../../topic/api/mutation/deleteLesson";
import {useEntityMutation} from "../../../shared/model/useEntityMutation";

export function useCreateLesson() {
    const {courseId} = useParams();

    return useEntityMutation<LessonStorePayload, LessonResponse>({
        mutationFn: storeLesson,
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания урока",
    });
}

export function useUpdateLesson() {
    const {courseId, lessonId} = useParams<{ courseId: string, lessonId: string }>();

    if (!lessonId) {
        throw new Error("lessonId is required");
    }

    return useEntityMutation<LessonUpdatePayload, LessonResponse>({
        mutationFn: (data) => updateLesson(Number(lessonId), data),
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка обновления урока"
    });
}

export function useDeleteLesson() {
    const { courseId } = useParams();

    return useEntityMutation({
        mutationFn: (lessonId: number) => deleteLesson(Number(lessonId)),
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка удаления урока"
    })
}
