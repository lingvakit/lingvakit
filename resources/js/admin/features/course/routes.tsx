import type {RouteObject} from "react-router-dom";
import CourseListPage from "../../pages/course/CourseListPage";
import type {BreadcrumbHandle} from "../../shared/types/router";
import CourseCreatePage from "../../pages/course/CourseCreatePage";
import CourseShowPage from "../../pages/course/CourseShowPage";
import {getCourse} from "./api/getCourse";

export const courseRoutes: RouteObject[] = [
    {
        handle: {
            title: "Курсы",
            breadcrumb: () => ({
                label: "Курсы",
                to: "/dashboard/coursesReact"
            }),
        } satisfies BreadcrumbHandle,
        children: [
            {
                index: true,
                element: <CourseListPage />
            },
            {
                path: "create",
                element: <CourseCreatePage />,
                handle: {
                    title: "Новый курс",
                    breadcrumb: () => ({
                        label: "Новый курс",
                        to: "/dashboard/coursesReact/create"
                    }),
                } satisfies BreadcrumbHandle,
            },
            {
                path: ":id",
                element: <CourseShowPage />,
                loader: getCourse,
                handle: {
                    title: "Курс",
                    breadcrumb: ({ params, data }) => {
                        const course = data as Awaited<ReturnType<typeof getCourse>>;

                        return {
                            label: course?.title ?? `Курс #${params.id}`,
                            to: `/dashboard/coursesReact/${params.id}`,
                        };
                    }
                } satisfies BreadcrumbHandle,
            },
        ]
    },
];