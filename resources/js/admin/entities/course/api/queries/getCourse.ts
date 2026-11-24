import { type LoaderFunctionArgs } from "react-router-dom";
import { Course } from "../../model/types";
import { baseApiUrl } from "@admin/shared/constants/api";
import { fetchLoaderData } from "@admin/shared/api/fetchLoaderData";

export async function getCourse({
    params,
    request,
}: LoaderFunctionArgs): Promise<Course> {
    const courseId = params.courseId;

    if (!courseId) {
        throw new Response("Missing courseId", { status: 400 });
    }

    return fetchLoaderData<Course>(`${baseApiUrl}/courses/${courseId}`, {
        signal: request.signal,
    });
}
