import React from "react";
import { PageItem, PaginatorMeta } from "../../types/pagination";
import { buildPagination } from "../../lib/buildPagination";


type Props = {
    paginatorMeta: PaginatorMeta;
    page: number;
    onPageChange: (page: number) => void;
};

export default function Pagination({paginatorMeta, page, onPageChange}: Props) {
    const items = buildPagination(page, paginatorMeta.last_page);

    const handlePrevPageChange = (
        e: React.MouseEvent
    ): void => {
        e.preventDefault();
        onPageChange(Math.max(1, page - 1));
    }

    const handleNextPageChange = (
        e: React.MouseEvent
    ): void => {
        e.preventDefault();
        onPageChange(Math.min(paginatorMeta.last_page, page + 1));
    }

    const handlePageChange = (
        e: React.MouseEvent,
        pageNumber: number
    ): void => {
        e.preventDefault();
        onPageChange(pageNumber);
    }



    return (
        <div className="row">
            <div className="col-sm-12 col-md-5">
                <div className="dataTables_info" id="sorting-table_info">
                    Показано {paginatorMeta.from} - {paginatorMeta.to} из {paginatorMeta.total} записей
                </div>
            </div>
            <div className="col-sm-12 col-md-7">
                <div className="dataTables_paginate paging_simple_numbers"
                     id="sorting-table_paginate">
                    <ul className="pagination">
                        <li className={`paginate_button page-item previous ${paginatorMeta.current_page === 1 ? "disabled" : ""}`}
                            id="sorting-table_previous">
                            <a
                                href="#"
                                className="page-link"
                                onClick={handlePrevPageChange}
                            >Пред.</a>
                        </li>

                        {items.map((pageItem: PageItem, index: number) => {
                            if (pageItem === "ellipsis") {
                                return (
                                    <li key={`e-${index}`} className="page-item disabled">
                                        <span className="page-link">...</span>
                                    </li>
                                );
                            }

                            return (
                                <li key={pageItem} className={`page-item ${pageItem === page ? "active" : ""}`}>
                                    <a
                                        href="#"
                                        className="page-link"
                                        onClick={(e: React.MouseEvent): void => handlePageChange(e, pageItem)}
                                    >
                                        {pageItem}
                                    </a>
                                </li>
                            );
                        })}


                        <li
                            className={`paginate_button page-item next ${paginatorMeta.current_page === paginatorMeta.last_page ? "disabled" : ""}`}
                            id="sorting-table_next">
                            <a
                                href="#"
                                className="page-link"
                                onClick={handleNextPageChange}
                            >След.</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    );
}