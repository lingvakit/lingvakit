import { ModuleCreatePayload, ModuleResponse } from "../../model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";

export async function createModule(
    payload: ModuleCreatePayload,
): Promise<ModuleResponse> {
    return fetchJson<ModuleResponse>(`${baseApiUrl}/modules`, {
        method: "POST",
        body: payload,
    });
}
