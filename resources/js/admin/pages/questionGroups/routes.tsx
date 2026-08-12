import {RouteObject} from "react-router-dom";
import {getQuiz} from "../../entities/quiz/queries/getQuiz";
import {BreadcrumbHandle} from "../../shared/ui/breadcrumbs/types";
import {QuestionsGroupCreatePage} from "./create/ui/QuestionsGroupCreatePage";
import QuestionGroupDetailsPage from "./details/ui/QuestionGroupDetailsPage";
import {getQuestionGroup} from "../../entities/questionGroup/api/queries/getQuestionGroup";
import {QuestionGroupEditPage} from "./edit/ui/QuestionGroupEditPage";

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
            },

            {
                handle: {
                    title: "Редактирование группы вопросов",
                    breadcrumb: ({ data }) => {
                        const questionGroup = data as Awaited<ReturnType<typeof getQuestionGroup>>;

                        return {
                            label: questionGroup.title
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: ":questionGroupUuid/edit",
                element: <QuestionGroupEditPage />,
                loader: getQuestionGroup
            },

            {
                handle: {
                    title: "Группа вопросов",
                    breadcrumb: () => {
                        return {
                            label: "Группа вопросов",
                        };
                    }
                } satisfies BreadcrumbHandle,

                path: ":questionGroupUuid",
                element: <QuestionGroupDetailsPage />,
                loader: getQuestionGroup,
            },
        ]
    }
];