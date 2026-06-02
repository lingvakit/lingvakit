export type PageItem = number | "ellipsis";

export type PaginatorMeta = {
    current_page: number;
    from: number;
    to: number;
    last_page: number;
    per_page: number;
    total: number;
};

export type Paginated<T> = {
    data: T[];
    meta: PaginatorMeta;
};

export type GetPaginateParams = {
    page: number;
    itemsPerPage: number;
    query?: string;
    signal?: AbortSignal;
    fileType?: string;
};

export type UsePaginatedListParams<TItem, TFilters extends Record<string, unknown> = {}> = {
    fetcher: (params: GetPaginateParams & TFilters) => Promise<Paginated<TItem>>,
    initialItemsPerPage?: number,
    filters?: TFilters,
    appendMode?: boolean
};

export type UsePaginatedListResult<TItem> = {
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