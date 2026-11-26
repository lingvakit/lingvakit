import { LessonStorePayload, Lesson } from "@admin/entities/lesson/model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function storeLesson(data: LessonStorePayload): Promise<Lesson> {
    const storeLessonEndpoint = `${baseApiUrl}/lessons`;

    return fetchJson<Lesson>(storeLessonEndpoint, {
        method: "POST",
        body: data,
    });
}
