import { RouteObject } from "react-router-dom";
import { lessonRoutes } from "@admin/pages/lessons/routes";
import { quizRoutes } from "@admin/pages/quizzes/routes";

export const moduleRoutes: RouteObject[] = [
    {
        path: ":courseId/modules",
        children: [...lessonRoutes, ...quizRoutes],
    },
];
