import { useCallback, useState } from "react";
import {
    type LessonFormInitialValues,
    type LessonFormValues,
    useLessonForm,
} from "@admin/features/lesson/model/useLessonForm";
import { useCKEditor } from "@admin/shared/ui/modal/media/useCKEditor";
import type { MediaFile } from "@admin/entities/media/model/types";
import type { MediaTarget } from "@admin/shared/ui/modal/media/types";
import { useMediaModalManager } from "@admin/shared/ui/modal/media/useMediaModalManager";
import PageLayout from "@admin/widgets/layout/PageLayout";
import LessonForm from "./LessonForm";
import MediaUploadModal from "@admin/shared/ui/modal/media/MediaUploadModal";
import { AiLessonContentFormModal } from "@admin/shared/ui/modal/ai-generator/AiLessonContentFormModal";

type Props = {
    title: string;
    initialValues?: LessonFormInitialValues;
    isSaving: boolean;
    error?: string | null;
    validationErrors?: Record<string, string[]>;
    onSubmit: (fields: LessonFormValues) => Promise<void>;
};

export function LessonFormScreen({
    title,
    initialValues,
    isSaving,
    error,
    validationErrors,
    onSubmit,
}: Props) {
    const form = useLessonForm(initialValues);
    const ckEditor = useCKEditor();

    const [isAiModalOpen, setIsAiModalOpen] = useState(false);

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

            <LessonForm
                ckEditor={ckEditor}
                isSavingProgress={isSaving}
                onSubmit={handleSubmit}
                openMediaModal={mediaModal.open}
                openAiModal={() => setIsAiModalOpen(true)}
                form={form}
                validationErrors={validationErrors}
            />

            <MediaUploadModal
                isOpen={mediaModal.isOpen}
                mediaType={mediaModal.mediaType}
                onClose={mediaModal.close}
                onSelect={mediaModal.handleSelect}
            />

            <AiLessonContentFormModal
                lessonTheme={form.fields.title}
                isOpen={isAiModalOpen}
                onClose={() => setIsAiModalOpen(false)}
                form={form}
            />
        </PageLayout>
    );
}
