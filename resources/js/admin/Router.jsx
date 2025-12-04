import React from "react";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import AdminContentLayout from "./layout/AdminContentLayout/AdminContentLayout.jsx";
import CourseListPage from "./pages/CoursePage/CourseListPage.jsx";
import CourseShowPage from "./pages/CoursePage/CourseShowPage.jsx";

export default function Router() {
    return (
        <BrowserRouter basename="/dashboard/react">
            <Routes>
                <Route element={<AdminContentLayout/>}>
                    <Route path="/courses" element={<CourseListPage/>}/>
                    <Route path="/courses/:id" element={<CourseShowPage/>}/>
                </Route>
            </Routes>
        </BrowserRouter>
    )
}