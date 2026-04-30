import {ModuleCreatePayload, ModuleResponse, ModuleUpdatePayload} from "./types";
import {createModule} from "../api/mutation/createModule";
import {useParams} from "react-router-dom";
import {useEntityMutation} from "../../../shared/model/useEntityMutation";
import {updateModule} from "../api/mutation/updateModule";

export function useCreateModule() {
    const {courseId} = useParams<{ courseId: string }>();

    return useEntityMutation<ModuleCreatePayload, ModuleResponse>({
        mutationFn: createModule,
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка создания модуля",
    });
}

export function useUpdateModule(moduleId: number) {
    const {courseId} = useParams<{ courseId: string }>();

    return useEntityMutation<ModuleUpdatePayload, ModuleResponse>({
        mutationFn: (payload) => {
            if (!moduleId) {
                return Promise.reject(new Error("moduleId is required"));
            }

            return updateModule(moduleId, payload);
        },
        onSuccessNavigateTo: courseId
            ? `/dashboard/coursesReact/${courseId}`
            : "/dashboard/coursesReact",
        errorMessage: "Ошибка обновления названия модуля"
    });
}
