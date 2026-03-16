import { fetchJson } from "../../../shared/api/fetchJson";
import { baseApiUrl } from "../../../shared/constants/api";
import { Category } from "../model/types";

export async function getCategoryList(): Promise<Category[]> {
    const json = await fetchJson<{ data: Category[] }>(`${baseApiUrl}/categories`);
    return json.data;
}
