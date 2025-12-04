import React, {useEffect, useState} from "react";
import {Link, useLocation} from "react-router-dom";

const titlesMap = {
    "courses": "Курсы"
};

export default function Breadcrumbs() {
    const location = useLocation();
    const [dynamicTitles, setDynamicTitles] = useState({});

    const parts = location.pathname.split("/").filter(Boolean);

    useEffect(() => {
        async function fetchDynamicParts() {
            let newDynamic = {};

            if (parts[0] === "courses" && parts[1]) {
                try {
                    const response = await fetch(`/api/v1/courses/${id}`);
                    const data = await response.json();
                    newDynamic[parts[1]] = data.title;
                } catch (error) {}
            }

            setDynamicTitles(newDynamic);
        }

        fetchDynamicParts();
    }, [location]);

    let currentPath = "";

    return (
        <ul className="breadcrumb">
            <li className="breadcrumb-item">
                <Link to="/">
                    <i className="ti ti-home"></i>
                </Link>
            </li>

            {parts.map((part, index) => {
                currentPath += `/${part}`;

                const title = dynamicTitles[part] || titlesMap[part] || part;
                const isLast = index === parts.length - 1;

                return (
                    <li
                        key={index}
                        className={`breadcrumb-item ${isLast ? "active" : ""}`}
                    >
                        {isLast ? (title) : (
                            <Link to={`${currentPath}`}>{title}</Link>
                        )}
                    </li>
                )
            })}
        </ul>
    )
}