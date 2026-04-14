import { fetchJson } from "../../../../shared/api/fetchJson";
import { baseApiUrl } from "../../../../shared/constants/api";
import { buildQuery } from "../../../../shared/lib/buildQuery";
import { GetPaginateParams, Paginated } from "../../../../shared/types/pagination";
import { Course } from "../../model/types";

export async function getCoursesList(
    params: GetPaginateParams
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