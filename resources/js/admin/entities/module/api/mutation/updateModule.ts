import {ModuleResponse, ModuleUpdatePayload} from "../../model/types";
import {fetchJson} from "../../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../../shared/constants/api";

export async function updateModule(
    moduleId: number,
    payload: ModuleUpdatePayload
): Promise<ModuleResponse> {
    const endpoint = `${baseApiUrl}/modules/${moduleId}`;

    return fetchJson<ModuleResponse>(endpoint, {
        method: "PUT",
        body: payload,
    });
}