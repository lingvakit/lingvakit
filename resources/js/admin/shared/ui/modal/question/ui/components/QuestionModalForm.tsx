import {FormEvent} from "react";
import {InputTextField} from "../../../../form/InputTextField";
import {InputNumberField} from "../../../../form/InputNumberField";
import {OptionField} from "../../../../../../pages/questionGroups/create/ui/components/Form/OptionField";
import {useQuestionForm} from "../../../../../../features/question/model/useQuestionForm";

type Props = {
    form: ReturnType<typeof useQuestionForm>;
    isSavingProcess: boolean;
    error: string|null;
    onSubmit: () => Promise<void>;
};

export function QuestionModalForm({
    form,
    isSavingProcess,
    error,
    onSubmit,
}: Props) {
    const handleSubmit = async (
        e: FormEvent
    ) => {
        e.preventDefault();
        await onSubmit();
    };

    return (
        <form
            className="form-horizontal"
            onSubmit={handleSubmit}
        >
            <div className="form-group">
                <div className="col-md-6 col-12">
                    <InputTextField
                        label="Текст вопроса"
                        name="text"
                        value={form.fields.text}
                        onChange={form.handlers.changeText}
                        isRequired={true}
                        placeholder="Введите текст вопроса"
                        isVertical={true}
                    />

                    <InputNumberField
                        label="Баллы"
                        name="points"
                        value={form.fields.points}
                        onChange={form.handlers.changeText}
                        isRequired={true}
                        isVertical={true}
                    />
                </div>

                <div className="col-md-6 col-12">
                    <label className="form-control-label">Варианты ответов</label>

                    {form.fields.options.map(option => (
                        <OptionField
                            key={option.uuid}
                            questionUuid={form.fields.uuid}
                            optionUuid={option.uuid}
                            value={option.text ?? ''}
                            checked={form.fields.answer.value[0] === option.uuid}

                            onTextChange={(optionUuid, value) => form.handlers.updateOption(
                                optionUuid,
                                'text',
                                value
                            )}

                            onCheckedChange={(optionUuid) => form.handlers.setCorrectOption(
                                optionUuid
                            )}
                        />
                    ))}

                    <div className="text-left add-option-container mt-3">
                        <button
                            type="button"
                            className="btn btn-shadow"
                            onClick={() => form.handlers.addOption()}
                        >Добавить вариант</button>
                    </div>
                </div>
            </div>

            <div
                className="widget-footer bordered no-actions d-flex align-items-center justify-content-between"
            >
                <button
                    className="btn btn-primary"
                    type="submit"
                    disabled={isSavingProcess}
                >
                    {isSavingProcess ? "Сохранение..." : "Сохранить"}
                </button>
            </div>
        </form>
    );
}