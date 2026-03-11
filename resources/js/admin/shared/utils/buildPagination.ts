import type {PageItem} from "../types/pagination";

export function buildPagination(currentPage: number, lastPage: number): PageItem[] {
    if (lastPage <= 0) return [];
    if (lastPage === 1) return [1];

    const pages: PageItem[] = [1];

    if (currentPage > 2) pages.push("ellipsis");
    if (currentPage !== 1 && currentPage !== lastPage) pages.push(currentPage);
    if (currentPage < lastPage - 1) pages.push("ellipsis");

    pages.push(lastPage);

    return pages;
}