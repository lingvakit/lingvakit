import {ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../../entities/media/model/types";
import {FontSize} from "./types";
import {QuestionPayload, QuestionType} from "../../../entities/question/model/types";
import {AiGeneratedQuestionsGroupPayload} from "../../../entities/questionGroup/model/types";
import {MEDIA_FIELD_BY_TYPE} from "../../../entities/media/model/constants";

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

    const applyAiData = (aiData: AiGeneratedQuestionsGroupPayload) => {
        const generatedQuestions: QuestionPayload[] = aiData.questions.map((aiQ) => {
            const questionUuid = crypto.randomUUID();

            const optionsWithUuid = aiQ.options.map(opt => ({
                uuid: crypto.randomUUID(),
                text: opt.text,
                _originalAiId: opt.id
            }));

            const correctOption = optionsWithUuid.find(
                opt => opt._originalAiId === aiQ.correct_answer_id
            );

            const cleanOptions: OptionValues[] = optionsWithUuid.map(
                ({ uuid, text }) => ({ uuid, text })
            );

            return {
                uuid: questionUuid,
                text: aiQ.question,
                type: "single_choice",
                explanation: aiQ.explanation,
                points: 10,
                orderIndex: null,
                settings: null,
                answer: {
                    type: 'single_choice',
                    value: [correctOption ? correctOption.uuid : '']
                },
                options: cleanOptions
            };
        });

        setForm(prev => {
            const isInitialEmpty = prev.questions.length === 1
                && !prev.questions[0].text
                && prev.questions[0].options.every(o => !o.text);

            const existingQuestions = isInitialEmpty ? [] : prev.questions;

            return {
                ...prev,
                title: prev.title.trim() === '' ? aiData.topic : prev.title,
                questions: [...existingQuestions, ...generatedQuestions]
            };
        });
    };

    const handleRemoveMediaFile = (type: MediaType): void => {
        const field = MEDIA_FIELD_BY_TYPE[type];

        setForm((prev) => ({
            ...prev,
            media: {
                ...prev.mediaFiles,
                [field]: null,
            },
        }));
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            setMediaFile,
            removeMediaFile: handleRemoveMediaFile,
            setMetaValue,
            addQuestion,
            addOption,
            updateQuestion,
            updateOption,
            setCorrectOption,
            applyAiData
        }
    };
}
