import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";
import { buildQuery } from "@admin/shared/lib/buildQuery";
import { GetPaginateParams, Paginated } from "@admin/shared/types/pagination";
import { Course } from "../../model/types";

export async function getCoursesList(
    params: GetPaginateParams,
): Promise<Paginated<Course>> {
    const query = buildQuery({
        page: params.page,
        per_page: params.itemsPerPage,
        q: params.query,
    });

    return fetchJson<Paginated<Course>>(`${baseApiUrl}/courses?${query}`, {
        signal: params.signal,
    });
}
