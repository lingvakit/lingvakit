import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";
import { CourseCreatePayload, CourseCreateResponse } from "../../model/types";

export async function createCourse(
    data: CourseCreatePayload,
): Promise<CourseCreateResponse> {
    return fetchJson<CourseCreateResponse>(`${baseApiUrl}/courses`, {
        method: "POST",
        body: data,
    });
}
