import {Topic} from "../../topic/model/types";

export type Module = {
    id: number;
    title: string;
    topics?: Topic[] | null;
};

export type ModuleCreatePayload = {
    title: string
};

export type ModuleCreateResponse = {
    data: Module
};

export type UseModuleCreateResult = {
    create: (
        courseId: number,
        payload: ModuleCreatePayload
    ) => Promise<Module | null>,
    isSaving: boolean,
    error: string | null
};
