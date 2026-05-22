import {ChangeEvent, useState} from "react";
import {MediaFile} from "../../../entities/media/model/types";
import {FontSize} from "./types";
import {QuestionPayload, QuestionType} from "../../../entities/question/model/types";

/* TODO: Check if need to remove it */
export type OptionValues = {
    uuid: string,
    text?: string | null,
    matchKey?: string | null,
    orderIndex?: number | null,
    settings?: {} | null,
};

/* TODO: Check if need to remove it */
export type QuestionValues = {
    uuid: string,
    text: string,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    settings?: {} | null,
    answer: {
        type: QuestionType,
        value: string,
    },
    options: OptionValues[],
};

type FormValues = {
    title: string,
    description: string,
    meta: {
        fontSize: FontSize
    },
    mediaFiles: {
        audio: MediaFile | null,
        image: MediaFile | null,
        video: MediaFile | null,
    },
    questions: QuestionPayload[],
};

export function useQuestionGroupForm(initial?: Partial<FormValues>) {
    const [form, setForm] = useState<FormValues>({
        title: initial?.title ?? '',
        description: initial?.description ?? '',
        meta: {
            fontSize: initial?.meta?.fontSize ?? 'small'
        },
        mediaFiles: {
            audio: initial?.mediaFiles?.audio ?? null,
            image: initial?.mediaFiles?.image ?? null,
            video: initial?.mediaFiles?.video ?? null,
        },
        questions: [
            {
                uuid: crypto.randomUUID(),
                text: '',
                type: "single_choice",
                explanation: '',
                points: 10,
                orderIndex: null,
                settings: null,
                answer: {
                    type: 'single_choice',
                    value: ['']
                },
                options: [
                    {
                        uuid: crypto.randomUUID(),
                        text: '',
                    },
                    {
                        uuid: crypto.randomUUID(),
                        text: '',
                    },
                ]
            }
        ]
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

    const setMediaFile = (
        file: MediaFile
    ) => {
        setForm(prev => ({
            ...prev,
            mediaFiles: {
                ...prev.mediaFiles,
                [file.type]: file
            }
        }));
    };

    const setMetaValue = <
        K extends keyof NonNullable<FormValues["meta"]>
    >(
        key: K,
        value: NonNullable<FormValues["meta"]>[K]
    ) => {
        setForm(prev => ({
            ...prev,
            meta: {
                ...prev.meta,
                [key]: value
            }
        }));
    };

    const addQuestion = () => {
        setForm(prev => ({
            ...prev,
            questions: [
                ...prev.questions,
                {
                    uuid: crypto.randomUUID(),
                    text: '',
                    type: 'single_choice',
                    explanation: '',
                    points: 10,
                    orderIndex: null,
                    settings: null,
                    answer: {
                        type: 'single_choice',
                        value: [''],
                    },
                    options: [
                        {
                            uuid: crypto.randomUUID(),
                            text: '',
                        },
                        {
                            uuid: crypto.randomUUID(),
                            text: '',
                        },
                    ],
                }
            ]
        }));
    };

    const addOption = (questionUuid: string) => {
        setForm(prev => ({
            ...prev,
            questions: prev.questions.map(question =>
                question.uuid === questionUuid
                    ? {
                        ...question,
                        options: [
                            ...question.options,
                            {
                                uuid: crypto.randomUUID(),
                                text: ''
                            }
                        ]
                    }
                    : question
            )
        }));
    };

    const updateQuestion = <
        K extends keyof QuestionValues
    >(
        questionUuid: string,
        key: K,
        value: QuestionValues[K],
    ): void => {
        setForm(prev => ({
            ...prev,
            questions: prev.questions.map(
                question => question.uuid === questionUuid
                    ? {
                        ...question,
                        [key]: value
                    }
                    : question
            )
        }))
    };

    /* TODO: Make UI page */
    const updateOption = <
        K extends keyof OptionValues
    >(
        questionUuid: string,
        optionUuid: string,
        key: K,
        value: OptionValues[K]
    ): void => {
        setForm(prev => ({
            ...prev,
            questions: prev.questions.map(question => {
                if (question.uuid !== questionUuid) {
                    return question;
                }

                return {
                    ...question,
                    options: question.options.map(
                        option => option.uuid === optionUuid
                            ? {
                                ...option,
                                [key]: value
                            }
                            : option
                    ),
                };
            })
        }))
    }

    const setCorrectOption = (
        questionUuid: string,
        optionUuid: string,
    ): void => {
        setForm(prev => ({
            ...prev,
            questions: prev.questions.map(
                question => question.uuid === questionUuid
                    ? {
                        ...question,
                        answer: {
                            type: 'single_choice',
                            value: [optionUuid]
                        },
                    }
                    : question
            )
        }))
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            setMediaFile,
            setMetaValue,
            addQuestion,
            addOption,
            updateQuestion,
            updateOption,
            setCorrectOption
        }
    };
}
