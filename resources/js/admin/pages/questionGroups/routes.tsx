import {RouteObject} from "react-router-dom";
import {getQuiz} from "../../entities/quiz/queries/getQuiz";
import {BreadcrumbHandle} from "../../shared/ui/breadcrumbs/types";
import {QuestionsGroupCreatePage} from "./create/ui/QuestionsGroupCreatePage";

export const questionGroupRoutes: RouteObject[] = [
    {
        loader: getQuiz,
        handle: {
            title: "Группа вопросов",
            breadcrumb: ({ params, data }) => {
                const quiz = data as Awaited<ReturnType<typeof getQuiz>>;

                return {
                    label: quiz?.title,
                    to: `/dashboard/coursesReact/${params.courseId}/modules/${params.moduleId}/quizzes/${params.quizUuid}`,
                };
            }
        } satisfies BreadcrumbHandle,

        path: ":quizUuid/questionGroups",
        children: [
            {
                handle: {
                    title: "Новая группа вопросов",
                    breadcrumb: () => {
                        return {
                            label: "Новая группа вопросов"
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: "create",
                element: <QuestionsGroupCreatePage />
            }
        ]
    }
];