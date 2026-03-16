import { createBrowserRouter } from "react-router-dom";
import BaseLayout from "./../../widgets/layout/BaseLayout";
import ErrorPage from "../../pages/error/ui/ErrorPage";
import NotFoundPage from "../../pages/not-found/ui/NotFoundPage";
import CourseListPage from "../../pages/courses/list/ui/CourseListPage";
import type { BreadcrumbHandle } from "../../shared/ui/breadcrumbs/types";
import { courseRoutes } from "../../pages/courses/routes";

export const router = createBrowserRouter([{
    path: "/dashboard/coursesReact",
    element: <BaseLayout />,
    errorElement: <ErrorPage />,
    handle: {
        title: "Курсы",
    } satisfies BreadcrumbHandle,
    children: [
        {
            index: true,
            element: <CourseListPage />,
        },

        {
            element: <CourseListPage />,
            handle: {
                title: "Курсы",
                breadcrumb: () => ({
                    label: "Курсы",
                    to: "/dashboard/coursesReact"
                }),
            } satisfies BreadcrumbHandle,
        },

        ...courseRoutes,

        { path: "*", element: <NotFoundPage /> },
    ]
}]);