import {QuestionType} from "./types";

interface OptionItem<T = string> {
    value: T,
    label: string
}

export const questionTypeDictionary: Record<QuestionType, string> = {
    single_choice: "Одиночный выбор",
    multiple_choice: "Множественный выбор",
    boolean: "Правда/ложь",
    fill_in_blank: "Заполнить пропуски",
    match: "Найти соответствия",
    sentence_build: "Составить текст",
    free_text: "Произвольный ответ",
};

export const questionTypeOptions: OptionItem<QuestionType>[] = (
    Object.entries(questionTypeDictionary) as [QuestionType, string][]
).map(([value, label]) => ({
    value,
    label
}));