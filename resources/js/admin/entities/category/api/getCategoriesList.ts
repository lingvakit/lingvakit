import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";
import { Category } from "../model/types";

export async function getCategoryList(
    signal?: AbortSignal,
): Promise<Category[]> {
    return fetchJson<Category[]>(`${baseApiUrl}/categories`, { signal });
}
