import {Paginated, PaginatorMeta} from "../types/pagination";
import React, {useEffect, useState} from "react";
import {useDebouncedValue} from "./useDebouncedValue.ts";

type BaseListParams = {
    page: number;
    itemsPerPage: number;
    query?: string;
    signal?: AbortSignal;
};

type UsePaginatedListParams<TItem, TFilters extends Record<string, unknown> = {}> = {
    fetcher: (params: BaseListParams & TFilters) => Promise<Paginated<TItem>>;
    initialItemsPerPage?: number;
    filters?: TFilters;
};

type UsePaginatedListResult<TItem> = {
    items: TItem[];
    paginatorMeta: PaginatorMeta | null;
    loading: boolean;
    error: string | null;
    page: number;
    setPage: React.Dispatch<React.SetStateAction<number>>;
    itemsPerPage: number;
    setItemsPerPage: React.Dispatch<React.SetStateAction<number>>;
    query: string;
    setQuery: React.Dispatch<React.SetStateAction<string>>;
};

export function usePaginatedList<
    TItem,
    TFilters extends Record<string, unknown> = {}
>({
      fetcher,
      initialItemsPerPage = 10,
      filters,
  }: UsePaginatedListParams<TItem, TFilters>
): UsePaginatedListResult<TItem> {
    const [query, setQuery] = useState("");
    const queryDebounced = useDebouncedValue(query, 500);

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

                setItems(response.data ?? []);
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
    }, [fetcher, page, itemsPerPage, queryDebounced, filters]);

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
