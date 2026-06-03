import {ChangeEvent, useState} from "react";

type FormValues = {
    theme: string,
    description: string,
    questionsQty: number,
    questionOptionsQty: number,
};

export function useAiQuestionForm(initial?: Partial<FormValues>) {
    const [form, setForm] = useState<FormValues>({
        theme: initial?.theme ?? '',
        description: initial?.description ?? '',
        questionsQty: initial?.questionsQty ?? 3,
        questionOptionsQty: initial?.questionOptionsQty ?? 4,
    });

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement|HTMLTextAreaElement|HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: String(value)
        }));
    };

    const handleNumberChange = (
        e: ChangeEvent<HTMLInputElement|HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: Number(value)
        }));
    };

    const setFieldValue = (
        name: keyof FormValues,
        value: string | number
    ): void => {
        setForm(prev => ({ ...prev, [name]: value }));
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            changeNumber: handleNumberChange,
        },
        setFieldValue,
    };
}
