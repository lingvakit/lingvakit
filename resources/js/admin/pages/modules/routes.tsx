import {RouteObject} from "react-router-dom";
import {lessonRoutes} from "../lessons/routes";
import {quizRoutes} from "../quizzes/routes";

export const moduleRoutes: RouteObject[] = [
    {
        path: ':courseId/modules',
        children: [
            ...lessonRoutes,
            ...quizRoutes,
        ]
    }
];