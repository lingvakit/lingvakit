import { type LoaderFunctionArgs } from "react-router-dom";
import { Course } from "../../model/types";
import { baseApiUrl } from "../../../../shared/constants/api";
import { fetchLoaderData } from "../../../../shared/api/fetchLoaderData";

export async function getCourse(
    { params, request }: LoaderFunctionArgs
): Promise<Course> {
    const id = params.id;

    if (!id) {
        throw new Response("Missing id", { status: 400 });
    }

    return fetchLoaderData<Course>(`${baseApiUrl}/courses/${id}`, {
        signal: request.signal
    });
}
