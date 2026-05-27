import {QuestionType} from "./types";

interface OptionItem<T = string> {
    value: T,
    label: string
}

export const questionTypeDictionary: Record<QuestionType, string> = {
    single_choice: "Одиночный выбор",
    multiple_choice: "Множественный выбор",
};

export const questionTypeOptions: OptionItem<QuestionType>[] = (
    Object.entries(questionTypeDictionary) as [QuestionType, string][]
).map(([value, label]) => ({
    value,
    label
}));