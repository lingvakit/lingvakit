import {getMediaFileList} from "../api/getMediaFileList";
import {MediaFile, MediaType} from "../types/mediaFile";
import {usePaginatedList} from "../../../shared/hooks/usePaginatedList";
import {useMemo} from "react";

export function useMediaList(mediaType: MediaType) {
    const filters = useMemo(
        () => ({fileType: mediaType}),
        [mediaType]
    );

    const result = usePaginatedList<MediaFile, {fileType: MediaType}>({
        fetcher: getMediaFileList,
        filters
    });

    return {
        mediaFiles: result.items,
        paginatorMeta: result.paginatorMeta,
        loading: result.loading,
        error: result.error,
        page: result.page,
        setPage: result.setPage,
        itemsPerPage: result.itemsPerPage,
        setItemsPerPage: result.setItemsPerPage,
        query: result.query,
        setQuery: result.setQuery,
    };
}
