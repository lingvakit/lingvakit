import {LoaderFunctionArgs} from "react-router-dom";
import {Quiz} from "../model/types";
import {fetchLoaderData} from "../../../shared/api/fetchLoaderData";
import {baseApiUrl} from "../../../shared/constants/api";

export async function getQuiz({
    params,
    request
}: LoaderFunctionArgs): Promise<Quiz> {
    const quizUuid = params.quizUuid;

    if (!quizUuid) {
        throw new Response("Missing quizUuid", { status: 400 });
    }

    return fetchLoaderData<Quiz>(`${baseApiUrl}/quizzes/${quizUuid}`, {
        signal: request.signal,
    })
}