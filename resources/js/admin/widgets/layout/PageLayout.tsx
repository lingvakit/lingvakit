import React from "react";
import Breadcrumbs from "../../shared/ui/breadcrumbs/Breadcrumbs";

export default function PageLayout(
    {title, children}: {
        title: string;
        children?: React.ReactNode
    }) {
    return (
        <>
            <div className="row">
                <div className="page-header">
                    <div className="d-flex align-items-center flex-wrap">
                        <h2 className="page-header-title">{title}</h2>
                        <div>
                            <Breadcrumbs />
                        </div>
                    </div>
                </div>
            </div>

            {children}
        </>
    );
}