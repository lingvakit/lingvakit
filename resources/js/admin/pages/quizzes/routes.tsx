import {RouteObject} from "react-router-dom";
import {QuizCreatePage} from "./create/ui/QuizCreatePage";
import {getCourse} from "../../entities/course/api/queries/getCourse";
import {BreadcrumbHandle} from "../../shared/ui/breadcrumbs/types";
import {getQuiz} from "../../entities/quiz/queries/getQuiz";
import {QuizEditPage} from "./edit/ui/QuizEditPage";
import {QuizDetailsPage} from "./show/ui/QuizDetailsPage";

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

            {
                handle: {
                    title: "Редактирование теста",
                    breadcrumb: ({ data }) => {
                        const quiz = data as Awaited<ReturnType<typeof getQuiz>>;

                        return {
                            label: quiz?.title,
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: ":quizUuid/edit",
                element: <QuizEditPage />,
                loader: getQuiz
            },

            {
                handle: {
                    title: "Страница теста",
                    breadcrumb: ({ data }) => {
                        const quiz = data as Awaited<ReturnType<typeof getQuiz>>;

                        return {
                            label: quiz?.title,
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: ":quizUuid",
                element: <QuizDetailsPage />,
                loader: getQuiz
            }
        ]
    },
];