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