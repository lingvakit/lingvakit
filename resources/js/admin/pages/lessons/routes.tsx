import {RouteObject} from "react-router-dom";
import LessonCreatePage from "./create/ui/LessonCreatePage";

export const lessonRoutes: RouteObject[] = [
    {
        path: ":moduleId/lessons",
        children: [
            {
                path: "create",
                element: <LessonCreatePage />,
            }
        ]
    }
];
