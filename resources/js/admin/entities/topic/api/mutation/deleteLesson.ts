import {baseApiUrl} from "../../../../shared/constants/api";
import {fetchJson} from "../../../../shared/api/fetchJson";

export function deleteLesson(
    lessonId: number
): Promise<void> {
    const deleteLessonEndpoint = `${baseApiUrl}/lessons/${lessonId}`;

    return fetchJson(deleteLessonEndpoint, {
        method: "DELETE",
        body: null
    });
}