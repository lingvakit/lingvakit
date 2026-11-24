import { QuestionGroup } from "../../model/types";
import type { LoaderFunctionArgs } from "react-router-dom";
import { fetchLoaderData } from "@admin/shared/api/fetchLoaderData";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function getQuestionGroup({
    params,
    request,
}: LoaderFunctionArgs): Promise<QuestionGroup> {
    const questionGroupUuid = params.questionGroupUuid;

    if (!questionGroupUuid) {
        throw new Response("Missing questionGroupUuid", { status: 400 });
    }

    return fetchLoaderData<QuestionGroup>(
        `${baseApiUrl}/questionGroups/${questionGroupUuid}`,
        {
            signal: request.signal,
        },
    );
}
