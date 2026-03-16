import { Topic } from "../../topic/model/types";

export type Module = {
    id: number;
    title: string;
    topics?: Topic[] | null;
};