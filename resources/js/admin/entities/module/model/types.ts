import {Topic} from "../../topic/model/types";

export type Module = {
    id: number;
    title: string;
    topics?: Topic[] | null;
};

export type ModuleCreatePayload = {
    courseId: number;
    title: string;
};

export type ModuleCreateResponse = {
    data: Module
};

export type UseModuleCreateResult = {
    create: (
        payload: ModuleCreatePayload
    ) => Promise<Module | null>,
    isSaving: boolean,
    error: string | null
};
