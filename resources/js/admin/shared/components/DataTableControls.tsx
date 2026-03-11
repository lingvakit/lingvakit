import React from "react";

type Props = {
    itemsPerPage: number;
    onItemsPerPageChange: (v: number) => void;
    searchQuery: string;
    onSearchQueryChange: (v: string) => void;
};

export default function DataTableControls({
    itemsPerPage,
    onItemsPerPageChange,
    searchQuery,
    onSearchQueryChange
}: Props) {
    const handleItemsPerPageChange = (
        e: React.ChangeEvent<HTMLSelectElement>
    ) => {
        onItemsPerPageChange(Number(e.target.value));
    };

    const handleSearchChange = (
        e: React.ChangeEvent<HTMLInputElement>
    ) => {
        onSearchQueryChange(e.target.value);
    };

    return (
        <div className="row">
            <div className="col-sm-12 col-md-6">
                <div className="dataTables_length" id="sorting-table_length">
                    <label>Показывать <select
                        className="form-control form-control-sm"
                        value={itemsPerPage}
                        onChange={handleItemsPerPageChange}
                    >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select> записей
                    </label>
                </div>
            </div>

            <div className="col-sm-12 col-md-6">
                <div id="sorting-table_filter" className="dataTables_filter">
                    <label>
                        Поиск: <input type="search"
                                      value={searchQuery}
                                      onChange={handleSearchChange}
                                      className="form-control form-control-sm" />
                    </label>
                </div>
            </div>
        </div>
    );
}