import { useCallback } from "react";
import PageLayout from "@admin/widgets/layout/PageLayout";
import { QuizForm } from "./QuizForm";
import { useCategoryList } from "@admin/entities/category/model/hooks";
import { useCKEditor } from "@admin/shared/ui/modal/media/useCKEditor";
import { useMediaModalManager } from "@admin/shared/ui/modal/media/useMediaModalManager";
import MediaUploadModal from "@admin/shared/ui/modal/media/MediaUploadModal";
import type { MediaFile } from "@admin/entities/media/model/types";
import type { MediaTarget } from "@admin/shared/ui/modal/media/types";
import {
    useQuizForm,
    type QuizFormInitialValues,
    type QuizFormValues,
} from "@admin/features/quiz/model/useQuizForm";

type Props = {
    title: string;
    initialValues?: QuizFormInitialValues;
    isSaving: boolean;
    error?: string | null;
    validationErrors?: Record<string, string[]>;
    onSubmit: (fields: QuizFormValues) => Promise<void>;
};

export function QuizFormScreen({
    title,
    initialValues,
    isSaving,
    error,
    validationErrors,
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
                validationErrors={validationErrors}
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
