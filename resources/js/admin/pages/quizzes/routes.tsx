import {RouteObject} from "react-router-dom";
import {QuizCreatePage} from "./create/ui/QuizCreatePage";
import {getCourse} from "../../entities/course/api/queries/getCourse";
import {BreadcrumbHandle} from "../../shared/ui/breadcrumbs/types";

export const quizRoutes: RouteObject[] = [
    {
        loader: getCourse,
        handle: {
            title: "Тесты",
            breadcrumb: ({ params, data }) => {
                const course = data as Awaited<ReturnType<typeof getCourse>>;

                return {
                    label: course?.title,
                    to: `/dashboard/coursesReact/${params.courseId}`,
                };
            }
        } satisfies BreadcrumbHandle,

        path: ":moduleId/quizzes",
        children: [
            {
                handle: {
                    title: "Новый тест",
                    breadcrumb: () => {
                        return {
                            label: "Новый тест",
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: "create",
                element: <QuizCreatePage />,
            },
        ]
    }
];