import {ChangeEvent, useEffect, useState} from "react";

type FormValues = {
    title: string
};

export function useModuleForm(initial?: Partial<FormValues>) {
    const [form, setForm] = useState<FormValues>({
        title: initial?.title ?? '',
    });

    useEffect(() => {
        setForm({
            title: initial?.title ?? ''
        });
    }, [initial?.title]);

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: String(value)
        }));
    };

    return {
        fields: form,
        handlers: {
            changeTitle: handleTextChange
        }
    };
}