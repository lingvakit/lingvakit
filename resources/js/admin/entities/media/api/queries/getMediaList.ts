import { GetPaginateParams, Paginated } from "../../../../shared/types/pagination";
import { MediaFile } from "../../model/types";
import { fetchJson } from "../../../../shared/api/fetchJson";
import { baseApiUrl } from "../../../../shared/constants/api";
import { buildQuery } from "../../../../shared/lib/buildQuery";

export async function getMediaList(
    params: GetPaginateParams
): Promise<Paginated<MediaFile>> {
    const query = buildQuery({
        page: String(params.page),
        per_page: String(params.itemsPerPage),
        q: params.query,
        type: params.fileType,
    })

    return fetchJson<Paginated<MediaFile>>(`${baseApiUrl}/media?${query}`, {
        signal: params.signal,
    });
}
