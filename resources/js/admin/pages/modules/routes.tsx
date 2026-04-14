import {RouteObject} from "react-router-dom";
import {lessonRoutes} from "../lessons/routes";

export const moduleRoutes: RouteObject[] = [
    {
        path: ':courseId/modules',
        children: [
            ...lessonRoutes
        ]
    }
];