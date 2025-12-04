import React, {useEffect, useState} from "react";
import Table from "./components/Table.jsx";

export default function CourseListPage() {
    const perPage = 5;

    const [pagination, setPagination] = useState(null);
    const [loading, setLoading] = useState(true);

    const fetchCourses = async (page = 1) => {
        try {
            setLoading(true);
            const response = await fetch(`/api/v1/courses?per_page=${perPage}&page=${page}`);
            const data = await response.json();

            if (data.current_page > data.last_page && data.last_page > 0) {
                return fetchCourses(data.last_page);
            }

            setPagination(data);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchCourses(1);
    }, []);

    const handlePageChange = (newPage) => {
        if (newPage < 1 || newPage > pagination.last_page || newPage === pagination.current_page) {
            return;
        }

        fetchCourses(newPage);
    };

    if (loading || !pagination) {
        return <div>Loading...</div>;
    }

    const {
        data,
        from,
        to,
        total,
        current_page,
        last_page
    } = pagination;

    return (
        <div className="row">
            <div className="col-xl-12">
                <div className="widget has-shadow">
                    <div
                        className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                    </div>
                    <div className="widget-body">
                        <div className="table-responsive">

                            <div id="sorting-table_wrapper" className="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div className="row">
                                    <div className="col-sm-12">
                                        <Table courses={data} />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-12 col-md-5">
                                        <div className="dataTables_info">
                                            Показано {from ?? 0} - {to ?? 0} из {total} курсов
                                        </div>
                                    </div>
                                    <div className="col-sm-12 col-md-7">
                                        <div id="sorting-table_paginate" className="dataTables_paginate paging_simple_numbers">
                                            <ul className="pagination">
                                                <li className={`paginate_button page-item previous ${current_page <= 1 ? "disabled" : ""}`}>
                                                    <a
                                                        href="#"
                                                        className="page-link"
                                                        onClick={() => handlePageChange(current_page - 1)}
                                                    >Пред.</a>
                                                </li>
                                                <li className="paginate_button page-item active">
                                                    <a href="#" className="page-link">{current_page}</a>
                                                </li>
                                                <li className={`paginate_button page-item next ${current_page >= last_page ? "disabled" : ""}`}>
                                                    <a
                                                        href="#"
                                                        className="page-link"
                                                        onClick={() => handlePageChange(current_page + 1)}
                                                    >След.</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}