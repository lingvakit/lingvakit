import type {Category} from "../types/category";
import {fetchJson} from "../../../shared/api/fetchJson.ts";
import {baseApiUrl} from "../../../shared/constants/api.ts";

export async function getCategoryList(): Promise<Category[]> {
    const json = await fetchJson<{ data: Category[] }>(`${baseApiUrl}/categories`);
    return json.data;
}
