import {type LoaderFunctionArgs} from "react-router-dom";
import type {Course} from "../types/course";
import {fetchLoaderData} from "../../../shared/api/fetchLoaderData";
import {baseApiUrl} from "../../../shared/constants/api";

export async function getCourse(
    {params, request}: LoaderFunctionArgs
): Promise<Course> {
    const id = params.id;

    if (!id) {
        throw new Response("Missing id", {status: 400});
    }

    return fetchLoaderData<Course>(`${baseApiUrl}/courses/${id}`, {
        signal: request.signal
    });
}
