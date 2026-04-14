import type {RouteObject} from "react-router-dom";
import { BreadcrumbHandle } from "../../shared/ui/breadcrumbs/types";
import CourseListPage from "./list/ui/CourseListPage";
import CourseCreatePage from "./create/ui/CourseCreatePage";
import CourseDetailsPage from "./details/ui/CourseDetailsPage";
import { getCourse } from "../../entities/course/api/queries/getCourse";
import {moduleRoutes} from "../modules/routes";

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
                path: ":courseId",
                element: <CourseDetailsPage />,
                loader: getCourse,
                handle: {
                    title: "Курс",
                    breadcrumb: ({ params, data }) => {
                        const course = data as Awaited<ReturnType<typeof getCourse>>;

                        return {
                            label: course?.title ?? `Курс #${params.courseId}`,
                            to: `/dashboard/coursesReact/${params.courseId}`,
                        };
                    }
                } satisfies BreadcrumbHandle,
            },

            ...moduleRoutes
        ]
    },
];