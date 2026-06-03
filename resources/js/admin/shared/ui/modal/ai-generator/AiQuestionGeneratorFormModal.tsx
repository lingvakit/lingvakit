import BaseModal from "../BaseModal";
import {FormEvent, useEffect} from "react";
import {InputTextField} from "../../form/InputTextField";
import {InputNumberField} from "../../form/InputNumberField";
import {TextareaField} from "../../form/TextareaField";
import {useAiQuestionForm} from "../../../hooks/useAiQuestionForm";

type Props = {
    theme: string,
    isOpen: boolean,
    onClose: () => void,
    isGeneratingProcess: boolean,
};

export function AiQuestionGeneratorFormModal({
    theme,
    isOpen,
    onClose,
    isGeneratingProcess
}: Props) {
    const form = useAiQuestionForm({theme});

    useEffect(() => {
        form.setFieldValue("theme", theme);
    }, [theme]);

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>,
    ): Promise<void> => {
        e.preventDefault();

        console.log('form sent...')
    }

    return (
        <BaseModal
            title="ИИ генератор вопросов для теста"
            isOpen={isOpen}
            onClose={onClose}
        >
            <form
                className="form-horizontal"
                onSubmit={handleSubmit}
            >
                <InputTextField
                    label="Тематика вопросов"
                    name="theme"
                    value={form.fields.theme}
                    onChange={form.handlers.changeText}
                    placeholder="Достопримечательности Шанхая"
                    isRequired={true}
                    isVertical={true}
                />

                <TextareaField
                    label="Детальное описание задания для ИИ"
                    name="description"
                    value={form.fields.description}
                    onChange={form.handlers.changeText}
                    placeholder="Опишите подробное задание для более точной генерации вопросов (не обязательное поле)"
                    isVertical={true}
                />

                <InputNumberField
                    label="Количество вопросов"
                    name="questionsQty"
                    value={form.fields.questionsQty}
                    onChange={form.handlers.changeNumber}
                    isRequired={true}
                    isVertical={true}
                    minDigit={1}
                    maxDigit={10}
                />

                <InputNumberField
                    label="Количество вариантов ответа"
                    name="questionOptionsQty"
                    value={form.fields.questionOptionsQty}
                    onChange={form.handlers.changeNumber}
                    isRequired={true}
                    isVertical={true}
                    minDigit={2}
                    maxDigit={6}
                />

                <div className="form-group">
                    <div className="col-12 mb-3">
                        <button
                            className="btn btn-gradient-01 mr-2"
                            type="submit"
                            disabled={isGeneratingProcess}
                        >{isGeneratingProcess ? 'Генерирую вопросы ...' : 'Генерировать вопросы'}</button>
                    </div>
                </div>
            </form>
        </BaseModal>
    );
}
