import React, {useEffect, useState} from "react";
import {useLocation, useParams} from "react-router-dom";


const staticTitles = {
    "/courses": "Курсы"
};

export default function Title() {
    const location = useLocation();
    const {id} = useParams();
    const [title, setTitle] = useState("");

    useEffect(() => {
        if (!id && staticTitles[location.pathname]) {
            setTitle(staticTitles[location.pathname]);
        }

        if (id) {
            fetch(`/api/v1/courses/${id}`)
                .then(res => res.json())
                .then((data) => setTitle(data.title))
                .catch(() => setTitle(""));
        }
    }, [id, location.pathname]);

    return <h2 className="page-header-title">{title}</h2>;
}