import {Lesson} from "../../lesson/model/types";

export type TopicType = "lesson" | "quiz";

export type Topic = {
    id: number;
    type: TopicType;
    orderIndex: number | null;
    lesson?: Lesson | null;
};
