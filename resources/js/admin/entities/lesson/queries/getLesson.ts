import {Lesson} from "../model/types";
import {LoaderFunctionArgs} from "react-router-dom";
import {fetchLoaderData} from "../../../shared/api/fetchLoaderData";
import {baseApiUrl} from "../../../shared/constants/api";

export async function getLesson(
    { params, request}: LoaderFunctionArgs
): Promise<Lesson> {
    const lessonId = params.lessonId;

    if (!lessonId) {
        throw new Response("Missing lessonId", { status: 400 });
    }

    return fetchLoaderData<Lesson>(`${baseApiUrl}/lessons/${lessonId}`, {
        signal: request.signal,
    })
}
