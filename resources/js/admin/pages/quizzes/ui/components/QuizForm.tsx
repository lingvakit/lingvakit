import { Category } from "@admin/entities/category/model/types";
import { useQuizForm } from "@admin/features/quiz/model/useQuizForm";
import { SelectCategories } from "./Form/SelectCategories";
import { InputTextField } from "@admin/shared/ui/form/InputTextField";
import { InputNumberField } from "@admin/shared/ui/form/InputNumberField";
import { TextareaCKEditorField } from "@admin/shared/ui/form/TextareaCKEditorField";
import { MediaTarget } from "@admin/shared/ui/modal/media/types";
import { MediaType } from "@admin/entities/media/model/types";
import { useCKEditor } from "@admin/shared/ui/modal/media/useCKEditor";
import { FormEvent } from "react";
import { InputMediaFiles } from "@admin/shared/ui/form/InputMediaFiles";

type Props = {
    form: ReturnType<typeof useQuizForm>;
    ckEditor: ReturnType<typeof useCKEditor>;
    validationErrors?: Record<string, string[]>;
    isSavingProgress: boolean;
    categoriesList?: Category[];
    isCategoriesLoading?: boolean;
    openMediaModal: (target: MediaTarget, type: MediaType) => void;
    onSubmit: () => Promise<void>;
};

export function QuizForm({
    form,
    ckEditor,
    validationErrors,
    isSavingProgress,
    categoriesList,
    isCategoriesLoading,
    openMediaModal,
    onSubmit,
}: Props) {
    const handleOpenMediaModal = (
        target: MediaTarget,
        type: MediaType,
    ): void => {
        openMediaModal(target, type);
    };

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>,
    ): Promise<void> => {
        e.preventDefault();
        await onSubmit();
    };

    return (
        <form className="form-horizontal" onSubmit={handleSubmit}>
            <div className="row flex-row">
                <div className="col-12">
                    <div className="widget has-shadow">
                        <div className="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                            <h4>Данные теста</h4>

                            <div className="text-right">
                                <button
                                    className="btn btn-primary"
                                    type="submit"
                                    disabled={isSavingProgress}
                                >
                                    {isSavingProgress
                                        ? "Сохранение..."
                                        : "Сохранить"}
                                </button>
                            </div>
                        </div>

                        <div className="widget-body">
                            <SelectCategories
                                form={form}
                                categoriesList={categoriesList}
                                isLoading={isCategoriesLoading}
                            />

                            <InputTextField
                                label="Заголовок теста"
                                name="title"
                                value={form.fields.title}
                                onChange={form.handlers.changeText}
                                isRequired={true}
                                placeholder="Название теста"
                                error={validationErrors?.title}
                            />

                            <TextareaCKEditorField
                                label="Описание"
                                value={form.fields.description}
                                onChange={form.handlers.setDescription}
                                onOpenMediaModal={handleOpenMediaModal}
                                setEditorRef={ckEditor.setEditorRef}
                                error={validationErrors?.description}
                            />

                            <InputMediaFiles
                                target="form"
                                mediaFiles={form.fields.mediaFiles}
                                onOpenMediaModal={handleOpenMediaModal}
                                onRemoveMediaFile={
                                    form.handlers.removeMediaFile
                                }
                            />

                            <InputNumberField
                                label="Ограничение времени прохождения теста, мин"
                                name="timeLimit"
                                value={form.fields.timeLimit}
                                onChange={form.handlers.changeNumber}
                                minDigit={1}
                                maxDigit={600}
                                error={validationErrors?.timeLimit}
                            />

                            <InputNumberField
                                label="Проходной балл, %"
                                name="passingScore"
                                value={form.fields.passingScore}
                                onChange={form.handlers.changeNumber}
                                minDigit={0}
                                maxDigit={100}
                                error={validationErrors?.passingScore}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    );
}
