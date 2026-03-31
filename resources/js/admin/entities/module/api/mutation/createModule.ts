import {ModuleCreatePayload, ModuleCreateResponse} from "../../model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function createModule(
    courseId: number,
    payload: ModuleCreatePayload
): Promise<ModuleCreateResponse> {
    return fetchJson<ModuleCreateResponse>(
        `${baseApiUrl}/courses/${courseId}/modules`,
        {
            method: "POST",
            body: payload,
        }
    );
}
