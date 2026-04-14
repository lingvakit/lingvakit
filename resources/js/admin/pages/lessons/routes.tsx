import {RouteObject} from "react-router-dom";
import LessonCreatePage from "./create/ui/LessonCreatePage";
import {LessonEditPage} from "./edit/ui/LessonEditPage";
import {getLesson} from "../../entities/lesson/queries/getLesson";

export const lessonRoutes: RouteObject[] = [
    {
        path: ":moduleId/lessons",
        children: [
            {
                path: "create",
                element: <LessonCreatePage />,
            },
            {
                path: ":lessonId/edit",
                element: <LessonEditPage />,
                loader: getLesson
            }
        ]
    }
];
