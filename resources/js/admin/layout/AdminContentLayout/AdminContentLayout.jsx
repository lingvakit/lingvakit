import React from "react";
import PageHeader from "./PageHeader.jsx";
import {Outlet} from "react-router-dom";

export default function AdminContentLayout() {
    return (


        <div className="container-fluid">
            <PageHeader/>

            <Outlet/>
        </div>
    );
}