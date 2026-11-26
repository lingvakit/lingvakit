import { RouteObject } from "react-router-dom";
import { getLesson } from "@admin/entities/lesson/queries/getLesson";
import { BreadcrumbHandle } from "@admin/shared/ui/breadcrumbs/types";
import { getCourse } from "@admin/entities/course/api/queries/getCourse";
import LessonCreatePage from "./ui/LessonCreatePage";
import { LessonEditPage } from "./ui/LessonEditPage";

export const lessonRoutes: RouteObject[] = [
    {
        loader: getCourse,
        handle: {
            title: "Урок",
            breadcrumb: ({ params, data }) => {
                const course = data as Awaited<ReturnType<typeof getCourse>>;

                return {
                    label: course?.title,
                    to: `/dashboard/coursesReact/${params.courseId}`,
                };
            },
        } satisfies BreadcrumbHandle,

        path: ":moduleId/lessons",
        children: [
            {
                handle: {
                    title: "Новый урок",
                    breadcrumb: () => {
                        return {
                            label: "Новый урок",
                        };
                    },
                } satisfies BreadcrumbHandle,

                path: "create",
                element: <LessonCreatePage />,
            },
            {
                handle: {
                    title: "Редактирование урока",
                    breadcrumb: ({ data }) => {
                        const lesson = data as Awaited<
                            ReturnType<typeof getLesson>
                        >;

                        return {
                            label: lesson?.title,
                        };
                    },
                } satisfies BreadcrumbHandle,

                path: ":lessonId/edit",
                element: <LessonEditPage />,
                loader: getLesson,
            },
        ],
    },
];
