import React from "react";
import parse from "html-react-parser";
import {Link} from "react-router-dom";

export default function TableRow({course}) {
    const {
        id,
        title,
        duration,
        imageUrl,
        publishDate
    } = course;

    return (
        <tr role="row" className="odd">
            <td style={{width: "100px"}}>
                <div className="table-img">
                    <img
                        src={imageUrl}
                        alt={title ? parse(title) : null}
                    />
                </div>
            </td>
            <td>
                <Link to={`/courses/${id}`} className="text-primary">
                    {title ? parse(title) : null}
                </Link>
            </td>
            <td style={{width: "150px"}}>{duration}</td>
            <td className="sorting_1" style={{width: "100px"}}>{publishDate}</td>
            <td className="td-actions" style={{width: "120px"}}>
                <Link to={`/courses/${id}`}>
                    <i className="la la-eye edit"></i>
                </Link>
            </td>
        </tr>
    );
};