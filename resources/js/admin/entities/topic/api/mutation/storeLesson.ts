import {LessonStorePayload, LessonStoreResponse} from "../../../lesson/model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function storeLesson(
    data: LessonStorePayload
): Promise<LessonStoreResponse> {
    const storeLessonEndpoint = `${baseApiUrl}/lessons`;

    return fetchJson<LessonStoreResponse>(storeLessonEndpoint, {
        method: "POST",
        body: data,
    });
}
