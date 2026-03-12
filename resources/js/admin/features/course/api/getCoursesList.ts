import type {Course} from "../types/course";
import type {Paginated} from "../../../shared/types/pagination";
import {buildQuery} from "../../../shared/api/buildQuery";
import {fetchJson} from "../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../shared/constants/api";

export type GetParams = {
    page: number;
    itemsPerPage: number;
    query?: string;
    signal?: AbortSignal;
};

export async function getCoursesList(
    params: GetParams
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