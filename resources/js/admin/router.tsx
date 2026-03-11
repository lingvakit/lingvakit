import {createBrowserRouter} from "react-router-dom";
import CourseListPage from "./pages/course/CourseListPage";
import BaseLayout from "./layouts/BaseLayout.tsx";
import {BreadcrumbHandle} from "./shared/types/router";
import {courseRoutes} from "./features/course/routes.tsx";
import ErrorPage from "./pages/ErrorPage.tsx";
import NotFoundPage from "./pages/NotFoundPage.tsx";

export const router = createBrowserRouter([{
    path: "/dashboard/coursesReact",
    element: <BaseLayout/>,
    errorElement: <ErrorPage/>,
    handle: {
        title: "Курсы",
    } satisfies BreadcrumbHandle,
    children: [
        {
            index: true,
            element: <CourseListPage/>,
        },

        {
            element: <CourseListPage/>,
            handle: {
                title: "Курсы",
                breadcrumb: () => ({
                    label: "Курсы",
                    to: "/dashboard/coursesReact"
                }),
            } satisfies BreadcrumbHandle,
        },

        ...courseRoutes,

        {path: "*", element: <NotFoundPage/>},
    ]
}]);