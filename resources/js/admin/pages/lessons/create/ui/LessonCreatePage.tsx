import PageLayout from "../../../../widgets/layout/PageLayout";
import LessonForm from "./components/LessonForm";
import {useCreateLesson} from "../../../../entities/lesson/model/hooks";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {MediaFile} from "../../../../entities/media/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {useLessonCreateForm} from "../../../../features/lesson/create/model/useLessonCreateForm";
import {useParams} from "react-router-dom";

export default function LessonCreatePage() {
    const { moduleId } = useParams();

    if (!moduleId) {
        throw new Error('Module Id is required');
    }

    const {saveLesson, isSavingProcess, error} = useCreateLesson();
    const ckEditor = useCKEditor();
    const formData = useLessonCreateForm();

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (file: MediaFile) => {
            formData.handlers.selectMediaFile(file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await saveLesson({
            moduleId: parseInt(moduleId),
            title: formData.fields.title,
            duration: formData.fields.duration,
            description: formData.fields.description,
            audioMediaId: formData.fields.mediaFiles.audio?.id,
            imageMediaId: formData.fields.mediaFiles.image?.id,
            videoMediaId: formData.fields.mediaFiles.video?.id,
        });
    };

    if (error) {
        return <>Ошибка: {error}</>
    }

    return (
        <PageLayout title="Новый урок">
            <LessonForm
                onSubmit={handleSubmit}
                isSavingProgress={isSavingProcess}
                ckEditor={ckEditor}
                openMediaModal={mediaModal.open}
                formData={formData}
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
