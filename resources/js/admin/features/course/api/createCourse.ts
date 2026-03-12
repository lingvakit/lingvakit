import type {CreateCoursePayload} from "../types/course";
import {fetchJson} from "../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../shared/constants/api";

type CreateCourseResponse = {
    data?: {
        id?: number;
    };
};

export async function createCourse(
    data: CreateCoursePayload
): Promise<CreateCourseResponse> {
    return fetchJson<CreateCourseResponse>(`${baseApiUrl}/courses`, {
        method: "POST",
        body: data,
    });
}
