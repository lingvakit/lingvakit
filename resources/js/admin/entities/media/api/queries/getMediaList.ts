import { GetPaginateParams, Paginated } from "@admin/shared/types/pagination";
import { MediaFile } from "../../model/types";
import { fetchJson } from "@admin/shared/api/fetchJson";
import { baseApiUrl } from "@admin/shared/constants/api";
import { buildQuery } from "@admin/shared/lib/buildQuery";

export async function getMediaList(
    params: GetPaginateParams,
): Promise<Paginated<MediaFile>> {
    const query = buildQuery({
        page: String(params.page),
        per_page: String(params.itemsPerPage),
        q: params.query,
        type: params.fileType,
    });

    return fetchJson<Paginated<MediaFile>>(`${baseApiUrl}/media?${query}`, {
        signal: params.signal,
    });
}
