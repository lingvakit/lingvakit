import {
    LessonResponse,
    LessonUpdatePayload,
} from "@admin/entities/lesson/model/types";
import { baseApiUrl } from "@admin/shared/constants/api";
import { fetchJson } from "@admin/shared/api/fetchJson";

export function updateLesson(
    lessonId: number,
    data: LessonUpdatePayload,
): Promise<LessonResponse> {
    const updateLessonEndpoint = `${baseApiUrl}/lessons/${lessonId}`;

    return fetchJson<LessonResponse>(updateLessonEndpoint, {
        method: "PUT",
        body: data,
    });
}
