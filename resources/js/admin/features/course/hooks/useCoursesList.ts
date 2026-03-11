import { useEffect, useState } from "react";
import type {Course} from "../types/course";
import type {PaginatorMeta} from "../../../shared/types/pagination";
import {getCoursesList} from "../api/getCoursesList";

export function useCoursesList() {
    const [query, setQuery] = useState("");
    const [queryDebounced, setQueryDebounced] = useState("");

    const [itemsPerPage, setItemsPerPage] = useState(10);
    const [page, setPage] = useState(1);

    const [items, setItems] = useState<Course[]>([]);
    const [paginatorMeta, setPaginatorMeta] = useState<PaginatorMeta | null>(null);

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const t = setTimeout(() => setQueryDebounced(query), 500);
        return () => clearTimeout(t);
    }, [query]);

    useEffect(() => {
        setPage(1);
    }, [itemsPerPage, queryDebounced]);

    useEffect(() => {
        const abortController = new AbortController();

        (async () => {
            try {
                setLoading(true);
                setError(null);

                const response = await getCoursesList({
                    page,
                    itemsPerPage: itemsPerPage,
                    query: queryDebounced,
                    signal: abortController.signal,
                });

                setItems(response.data ?? []);
                setPaginatorMeta(response.meta ?? null);
            } catch (e: any) {
                if (e?.name !== "AbortError") setError(e?.message ?? "Unknown error");
            } finally {
                setLoading(false);
            }
        })();

        return () => abortController.abort();
    }, [page, itemsPerPage, queryDebounced]);

    return {
        items,
        paginatorMeta: paginatorMeta,
        loading,
        error,
        page,
        setPage,
        itemsPerPage: itemsPerPage,
        setItemsPerPage: setItemsPerPage,
        query: query,
        setQuery: setQuery,
    };
}