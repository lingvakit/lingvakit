import React from "react";
import Breadcrumbs from "./Breadcrumbs.jsx";
import Title from "./Title.jsx";

export default function PageHeader() {
    return (
        <div className="row">
            <div className="page-header">
                <div className="d-flex align-items-center flex-wrap">
                    <Title/>
                    <div>
                        <Breadcrumbs/>
                    </div>
                </div>
            </div>
        </div>
    )
}