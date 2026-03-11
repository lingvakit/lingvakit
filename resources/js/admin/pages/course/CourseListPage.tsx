import {Link} from "react-router-dom";
import DataTableControls from "../../shared/components/DataTableControls";
import {useCoursesList} from "../../features/course/hooks/useCoursesList";
import CoursesTable from "../../features/course/components/CoursesTable";
import Pagination from "../../shared/components/Pagination";
import PageLayout from "../../layouts/PageLayout";

export default function CourseListPage() {
    const {
        items,
        paginatorMeta,
        page,
        setPage,
        itemsPerPage,
        setItemsPerPage,
        query,
        setQuery,
        error
    } = useCoursesList();

    return (
        <PageLayout title="Курсы">
            <div className="row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div
                            className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Фильтр</h4>
                            <div className="form-group">
                                <Link
                                    to={`/dashboard/coursesReact/create`}
                                    className="btn btn-primary mr-1 mb-2"
                                >Добавить</Link>
                            </div>
                        </div>

                        <div className="widget-body">
                            <div className="table-responsive">
                                <div id="sorting-table_wrapper"
                                     className="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                                    <DataTableControls
                                        itemsPerPage={itemsPerPage}
                                        onItemsPerPageChange={setItemsPerPage}
                                        searchQuery={query}
                                        onSearchQueryChange={setQuery}
                                    />

                                    <CoursesTable items={items} />

                                    {paginatorMeta &&
                                        <Pagination
                                            paginatorMeta={paginatorMeta}
                                            page={page}
                                            onPageChange={setPage}
                                        />
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </PageLayout>
    );
}