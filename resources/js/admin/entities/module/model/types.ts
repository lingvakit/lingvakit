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

export type ModuleUpdatePayload = {
    title: string;
};

export type ModuleCreateResponse = {
    data: Module
};
