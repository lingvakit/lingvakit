import PageLayout from "../../../../widgets/layout/PageLayout";
import LessonForm from "./components/LessonForm";
import {useCreateLesson} from "../../../../entities/lesson/model/hooks";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {MediaFile} from "../../../../entities/media/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {useParams} from "react-router-dom";
import {useLessonForm} from "../../../../features/lesson/create/model/useLessonForm";
import {AiLessonContentFormModal} from "../../../../shared/ui/modal/ai-generator/AiLessonContentFormModal";
import {useState} from "react";
import {MediaTarget} from "../../../../shared/ui/modal/media/types";

export default function LessonCreatePage() {
    const { moduleId } = useParams();

    if (!moduleId) {
        throw new Error('Module Id is required');
    }

    const [isAiModalOpen, setIsAiModalOpen] = useState(false);

    const {execute, isSavingProcess, error} = useCreateLesson();
    const ckEditor = useCKEditor();
    const form = useLessonForm();

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (target: MediaTarget, file: MediaFile) => {
            form.handlers.setMediaFile(file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await execute({
            moduleId: parseInt(moduleId),
            title: form.fields.title,
            duration: form.fields.duration,
            description: form.fields.description,
            audioMediaId: form.fields.mediaFiles.audio?.id,
            imageMediaId: form.fields.mediaFiles.image?.id,
            videoMediaId: form.fields.mediaFiles.video?.id,
        });
    };

    if (error) {
        return <>Ошибка: {error}</>
    }

    return (
        <PageLayout title="Новый урок">
            <LessonForm
                ckEditor={ckEditor}
                isSavingProgress={isSavingProcess}
                onSubmit={handleSubmit}
                openMediaModal={mediaModal.open}
                openAiModal={() => setIsAiModalOpen(true)}
                form={form}
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
