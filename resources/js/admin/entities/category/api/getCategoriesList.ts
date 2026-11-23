import { fetchJson } from "../../../shared/api/fetchJson";
import { baseApiUrl } from "../../../shared/constants/api";
import { Category } from "../model/types";

export async function getCategoryList(
    signal?: AbortSignal,
): Promise<Category[]> {
    return fetchJson<Category[]>(`${baseApiUrl}/categories`, { signal });
}
