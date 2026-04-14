import { Link } from "react-router-dom";
import { Course } from "../../../../../entities/course/model/types";
import { formatDate } from "../../../../../shared/lib/converter";

type Props = {
    items: Course[];
};

export default function CoursesTable({ items }: Props) {
    return (
        <div className="row">
            <div className="col-sm-12">
                <table className="table mb-0">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Курс</th>
                            <th>Дата публикации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        {items.map((course: Course) => (
                            <tr key={course.id}>
                                <td style={{ width: 100 }}>
                                    <div className="table-img">
                                        <img src={course.imageUrl} style={{ width: 100 }} alt="" />
                                    </div>
                                </td>
                                <td>{course.title}</td>
                                <td>{formatDate(course.createdAt)}</td>
                                <td className="td-actions">
                                    <Link to={`/dashboard/coursesReact/${course.id}`}>
                                        <i className="la la-eye edit" />
                                    </Link>
                                    <a href="#"><i className="la la-ban edit" /></a>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}

