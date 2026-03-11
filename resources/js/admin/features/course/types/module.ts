import type {Topic} from "./topic";

export type Module = {
    id: number;
    title: string;
    topics?: Topic[] | null;
};
