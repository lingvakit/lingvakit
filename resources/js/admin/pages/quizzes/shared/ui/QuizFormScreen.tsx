import { useCallback } from "react";
import PageLayout from "../../../../widgets/layout/PageLayout";
import { QuizForm } from "./QuizForm";
import { useCategoryList } from "../../../../entities/category/model/hooks";
import { useQuizForm } from "../../../../features/quiz/model/useQuizForm";
import type { QuizFormFields } from "../../../../features/quiz/lib/buildQuizPayload";
import { useCKEditor } from "../../../../shared/ui/modal/media/useCKEditor";
import { useMediaModalManager } from "../../../../shared/ui/modal/media/useMediaModalManager";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import type { MediaFile } from "../../../../entities/media/model/types";
import type { MediaTarget } from "../../../../shared/ui/modal/media/types";
import type { QuizFormInitialValues } from "../../../../features/quiz/model/useQuizForm";

type Props = {
    title: string;
    initialValues?: QuizFormInitialValues;
    isSaving: boolean;
    error?: string | null;
    onSubmit: (fields: QuizFormFields) => Promise<void>;
};

export function QuizFormScreen({
    title,
    initialValues,
    isSaving,
    error,
    onSubmit,
}: Props) {
    const form = useQuizForm(initialValues);
    const ckEditor = useCKEditor();
    const {
        categoryList,
        isLoading: isCategoriesLoading,
        error: categoriesError,
        reload: reloadCategories,
    } = useCategoryList();

    const handleFormMediaSelect = useCallback(
        (_target: MediaTarget, file: MediaFile): void => {
            form.handlers.setMediaFile(file);
        },
        [form.handlers],
    );

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: handleFormMediaSelect,
    });

    const handleSubmit = useCallback(
        () => onSubmit(form.fields),
        [onSubmit, form.fields],
    );

    return (
        <PageLayout title={title}>
            {error && (
                <div className="alert alert-danger" role="alert">
                    {error}
                </div>
            )}

            {categoriesError && (
                <div
                    className="alert alert-warning d-flex justify-content-between align-items-center"
                    role="alert"
                >
                    <span>
                        Не удалось загрузить категории: {categoriesError}
                    </span>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-secondary"
                        onClick={reloadCategories}
                    >
                        Повторить
                    </button>
                </div>
            )}

            <QuizForm
                form={form}
                ckEditor={ckEditor}
                isSavingProgress={isSaving}
                categoriesList={categoryList}
                isCategoriesLoading={isCategoriesLoading}
                openMediaModal={mediaModal.open}
                onSubmit={handleSubmit}
            />

            <MediaUploadModal
                isOpen={mediaModal.isOpen}
                mediaType={mediaModal.mediaType}
                onClose={mediaModal.close}
                onSelect={mediaModal.handleSelect}
            />
        </PageLayout>
    );
}
