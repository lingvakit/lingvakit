import React from "react";
import TableRow from "./TableRow.jsx";

export default function Table({courses}) {
    return (
        <table className="table mb-0 dataTable no-footer" aria-describedby="sorting-table_info">
            <thead>
            <tr role="row">
                <th>Изображение</th>
                <th>Курс</th>
                <th>Длительность</th>
                <th>Опубликован</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            {courses.map((course) => (
                <TableRow key={course.id} course={course} />
            ))}
            </tbody>
        </table>
    );
}