import { createBrowserRouter } from "react-router-dom";
import BaseLayout from "@admin/widgets/layout/BaseLayout";
import ErrorPage from "@admin/pages/error/ui/ErrorPage";
import NotFoundPage from "@admin/pages/not-found/ui/NotFoundPage";
import CourseListPage from "@admin/pages/courses/list/ui/CourseListPage";
import type { BreadcrumbHandle } from "@admin/shared/ui/breadcrumbs/types";
import { courseRoutes } from "@admin/pages/courses/routes";

export const router = createBrowserRouter([
    {
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
                        to: "/dashboard/coursesReact",
                    }),
                } satisfies BreadcrumbHandle,
            },

            ...courseRoutes,

            { path: "*", element: <NotFoundPage /> },
        ],
    },
]);
