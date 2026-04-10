import {LessonResponse, LessonUpdatePayload} from "../../../lesson/model/types";
import {baseApiUrl} from "../../../../shared/constants/api";
import {fetchJson} from "../../../../shared/api/fetchJson";

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
