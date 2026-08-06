import {QuestionType} from "../../../entities/question/model/types";
import {MediaFields} from "../../../shared/types/form";
import {ChangeEvent, useState} from "react";
import {MediaFile, MediaType} from "../../../entities/media/model/types";
import {MEDIA_FIELD_BY_TYPE} from "../../../entities/media/model/constants";

export type OptionValues = {
    questionUuid: string,
    uuid: string,
    text?: string | null,
    matchKey?: string | null,
    orderIndex?: number | null,
    settings?: {} | null,
};

type FormValues = {
    uuid: string,
    text: string,
    type: QuestionType,
    explanation?: string | null,
    points: number,
    orderIndex?: number | null,
    settings?: {} | null,
    mediaFiles: MediaFields,
    answer: {
        questionType: QuestionType,
        value: string[],
    },
    options: OptionValues[],
};

export function useQuestionForm(initial?: Partial<FormValues>) {
    const questionUuid = crypto.randomUUID();

    const [form, setForm] = useState<FormValues>({
        uuid: questionUuid,
        text: '',
        type: "single_choice",
        explanation: '',
        points: 10,
        orderIndex: null,
        settings: null,
        mediaFiles: {
            audio: null,
            image: null,
            video: null,
        },
        answer: {
            questionType: 'single_choice',
            value: ['']
        },
        options: [
            {
                questionUuid: questionUuid,
                uuid: crypto.randomUUID(),
                text: '',
            },
            {
                questionUuid: questionUuid,
                uuid: crypto.randomUUID(),
                text: '',
            },
        ]
    });

    const handleTextChange = (
        e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>
    ): void => {
        const { name, value } = e.target;

        setForm(prev => ({
            ...prev,
            [name]: name === 'points' ? Number(value) : String(value)
        }));
    };

    const setMediaFile = (file: MediaFile): void => {
        const field = MEDIA_FIELD_BY_TYPE[file.type];

        setForm(prev => ({
            ...prev,
            mediaFiles: { ...prev.mediaFiles, [field]: file }
        }));
    };

    const handleRemoveMediaFile = (type: MediaType): void => {
        const field = MEDIA_FIELD_BY_TYPE[type];

        setForm(prev => ({
            ...prev,
            mediaFiles: { ...prev.mediaFiles, [field]: null }
        }));
    };

    const addOption = () => {
        setForm(prev => ({
            ...prev,
            options: [
                ...prev.options,
                {
                    questionUuid: questionUuid,
                    uuid: crypto.randomUUID(),
                    text: ''
                }
            ]
        }));
    };

    const updateOption = <K extends keyof OptionValues>(
        optionUuid: string,
        key: K,
        value: OptionValues[K]
    ): void => {
        setForm(prev => ({
            ...prev,
            options: prev.options.map(option =>
                option.uuid === optionUuid
                    ? { ...option, [key]: value }
                    : option
            ),
        }));
    };

    const removeOption = (optionUuid: string): void => {
        setForm(prev => ({
            ...prev,
            options: prev.options.filter(option => option.uuid !== optionUuid)
        }));
    };

    const setCorrectOption = (optionUuid: string): void => {
        setForm(prev => ({
            ...prev,
            answer: {
                questionType: prev.type,
                value: [optionUuid]
            },
        }));
    };

    return {
        fields: form,
        handlers: {
            changeText: handleTextChange,
            setMediaFile,
            removeMediaFile: handleRemoveMediaFile,
            addOption,
            updateOption,
            removeOption,
            setCorrectOption,
        }
    };
}
