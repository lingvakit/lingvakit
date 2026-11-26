import {
    Lesson,
    LessonUpdatePayload,
} from "@admin/entities/lesson/model/types";
import { baseApiUrl } from "@admin/shared/constants/api";
import { fetchJson } from "@admin/shared/api/fetchJson";

export function updateLesson(
    lessonId: number,
    data: LessonUpdatePayload,
): Promise<Lesson> {
    const updateLessonEndpoint = `${baseApiUrl}/lessons/${lessonId}`;

    return fetchJson<Lesson>(updateLessonEndpoint, {
        method: "PUT",
        body: data,
    });
}
