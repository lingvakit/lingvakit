import {
    LessonStorePayload,
    LessonResponse,
} from "@admin/entities/lesson/model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function storeLesson(
    data: LessonStorePayload,
): Promise<LessonResponse> {
    const storeLessonEndpoint = `${baseApiUrl}/lessons`;

    return fetchJson<LessonResponse>(storeLessonEndpoint, {
        method: "POST",
        body: data,
    });
}
