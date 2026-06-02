import { useEffect, useState } from "react";
import { PaginatorMeta, UsePaginatedListParams, UsePaginatedListResult } from "../types/pagination";
import { useDebounce } from "./useDebounce";

export function usePaginatedList<
    TItem,
    TFilters extends Record<string, unknown> = {}
>({
      fetcher,
      initialItemsPerPage = 10,
      filters,
      appendMode = false,
  }: UsePaginatedListParams<TItem, TFilters> & { appendMode?: boolean }
): UsePaginatedListResult<TItem> {
    const [query, setQuery] = useState("");
    const queryDebounced = useDebounce(query, 500);

    const [itemsPerPage, setItemsPerPage] = useState(initialItemsPerPage);
    const [page, setPage] = useState(1);

    const [items, setItems] = useState<TItem[]>([]);
    const [paginatorMeta, setPaginatorMeta] = useState<PaginatorMeta | null>(null);

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        setPage(1);
    }, [itemsPerPage, queryDebounced, filters]);

    useEffect(() => {
        const abortController = new AbortController();

        (async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await fetcher({
                    page,
                    itemsPerPage,
                    query: queryDebounced,
                    signal: abortController.signal,
                    ...(filters ?? ({} as TFilters)),
                });

                const newItems = response.data ?? [];

                if (appendMode && page > 1) {
                    setItems(prevItems => [...prevItems, ...newItems]);
                } else {
                    setItems(newItems);
                }

                setPaginatorMeta(response.meta ?? null);
            } catch (e: unknown) {
                if (e instanceof Error && e.name !== "AbortError") {
                    setError(e.message);
                } else if (!(e instanceof Error)) {
                    setError("Unknown error");
                }
            } finally {
                setLoading(false);
            }
        })();

        return () => abortController.abort();
    }, [
        fetcher,
        page,
        itemsPerPage,
        queryDebounced,
        filters,
        appendMode
    ]);

    return {
        items,
        paginatorMeta,
        loading,
        error,
        page,
        setPage,
        itemsPerPage,
        setItemsPerPage,
        query,
        setQuery,
    };
}
