import {useLoaderData} from "react-router-dom";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {Lesson} from "../../../../entities/lesson/model/types";
import LessonForm from "../../create/ui/components/LessonForm";
import {useUpdateLesson} from "../../../../entities/lesson/model/hooks";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaFile} from "../../../../entities/media/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useLessonForm} from "../../../../features/lesson/create/model/useLessonForm";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {AiLessonContentFormModal} from "../../../../shared/ui/modal/ai-generator/AiLessonContentFormModal";
import {useState} from "react";

export function LessonEditPage() {
    const [isAiModalOpen, setIsAiModalOpen] = useState(false);

    const lesson = useLoaderData() as Lesson;

    const {execute, isSavingProcess, error} = useUpdateLesson();
    const ckEditor = useCKEditor();
    const form = useLessonForm({
        title: lesson.title,
        duration: lesson.duration,
        description: lesson.description,
        mediaFiles: {
            audio: lesson.audioFile,
            image: lesson.imageFile,
            video: lesson.videoFile,
        }
    });

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (file: MediaFile) => {
            form.handlers.setMediaFile(file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await execute(form.fields);
    }

    if (error) {
        return <>Ошибка: {error}</>
    }

    return (
        <PageLayout title={lesson.title}>
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