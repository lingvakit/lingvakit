import {ModuleCreatePayload, ModuleResponse} from "../../model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function createModule(
    payload: ModuleCreatePayload
): Promise<ModuleResponse> {
    return fetchJson<ModuleResponse>(
        `${baseApiUrl}/modules`,
        {
            method: "POST",
            body: payload,
        }
    );
}
