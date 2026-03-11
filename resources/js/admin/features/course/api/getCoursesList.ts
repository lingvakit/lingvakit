import type {Course} from "../types/course";
import type {Paginated} from "../../../shared/types/pagination";

export type GetCoursesParams = {
    page: number;
    itemsPerPage: number;
    query?: string;
    signal?: AbortSignal;
};

export async function getCoursesList(params: GetCoursesParams): Promise<Paginated<Course>> {
    const querySearch = new URLSearchParams({
        page: String(params.page),
        per_page: String(params.itemsPerPage),
    });

    if (params.query?.trim()) querySearch.set("q", params.query.trim());

    const response = await fetch(`/react/api/courses?${querySearch.toString()}`, {
        method: "GET",
        credentials: "include",
        signal: params.signal,
        headers: { Accept: "application/json" },
    });

    if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
    }

    return response.json();
}