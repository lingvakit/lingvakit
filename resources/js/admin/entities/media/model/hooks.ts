import { useMemo } from "react";
import { MediaFile, MediaType } from "./types";
import { getMediaList } from "../api/queries/getMediaList";
import { usePaginatedList } from "../../../shared/hooks/usePagination";

export function useMediaList(mediaType: MediaType) {
    const filters = useMemo(
        () => ({fileType: mediaType}),
        [mediaType]
    );

    const result = usePaginatedList<MediaFile, {fileType: MediaType}>({
        fetcher: getMediaList,
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
