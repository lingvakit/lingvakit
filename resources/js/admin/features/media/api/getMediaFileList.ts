import {MediaFile} from "../types/mediaFile";
import {Paginated} from "../../../shared/types/pagination";
import {buildQuery} from "../../../shared/api/buildQuery";
import {fetchJson} from "../../../shared/api/fetchJson";
import {baseApiUrl} from "../../../shared/constants/api";

type GetParams = {
    page: number;
    itemsPerPage: number;
    query?: string;
    fileType?: string;
    signal?: AbortSignal;
};

export async function getMediaFileList(
    params: GetParams
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
