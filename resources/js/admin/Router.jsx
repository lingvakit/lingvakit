import React from "react";
import {BrowserRouter, Route, Routes} from "react-router-dom";
import AdminContentLayout from "./layout/AdminContentLayout/AdminContentLayout.jsx";
import CourseListPage from "./pages/CoursePage/CourseListPage.jsx";
import CourseShowPage from "./pages/CoursePage/CourseShowPage.jsx";
import QuizCreatePage from "./pages/QuizPage/CourseCreatePage.jsx";

export default function Router() {
    return (
        <BrowserRouter basename="/dashboard/react">
            <Routes>
                <Route element={<AdminContentLayout/>}>
                    {/* Course */}
                    <Route path="/courses" element={<CourseListPage/>}/>
                    <Route path="/courses/:courseId" element={<CourseShowPage/>}/>

                    {/* Quiz */}
                    <Route path="/courses/:courseId/modules/:moduleId/quizzes/create" element={<QuizCreatePage/>}/>
                </Route>
            </Routes>
        </BrowserRouter>
    )
}