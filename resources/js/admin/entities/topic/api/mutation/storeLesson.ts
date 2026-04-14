import {LessonStorePayload, LessonResponse} from "../../../lesson/model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function storeLesson(
    data: LessonStorePayload
): Promise<LessonResponse> {
    const storeLessonEndpoint = `${baseApiUrl}/lessons`;

    return fetchJson<LessonResponse>(storeLessonEndpoint, {
        method: "POST",
        body: data,
    });
}
