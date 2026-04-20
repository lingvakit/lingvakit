import PageLayout from "../../../../widgets/layout/PageLayout";
import {QuizForm} from "./components/QuizForm";
import {useCategoryList} from "../../../../entities/category/model/hooks";
import {useQuizForm} from "../../../../features/quiz/model/useQuizForm";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaFile} from "../../../../entities/media/model/types";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {useCreateQuiz} from "../../../../entities/quiz/model/hooks";
import {useParams} from "react-router-dom";

export function QuizCreatePage() {
    const { moduleId } = useParams();

    if (!moduleId) {
        throw new Error('Module Id is required');
    }

    const form = useQuizForm();
    const ckEditor = useCKEditor();
    const {categoryList} = useCategoryList();
    const {execute, isSavingProcess, error} = useCreateQuiz();

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (file: MediaFile) => {
            form.handlers.setMediaFile(file)
        }
    });

    const handleSubmit = async (): Promise<void> => {
        await execute({
            moduleId: parseInt(moduleId),
            uuid: crypto.randomUUID(),
            title: form.fields.title,
            description: form.fields.description,
            audioMediaId: form.fields.mediaFiles.audio?.id,
            imageMediaId: form.fields.mediaFiles.image?.id,
            videoMediaId: form.fields.mediaFiles.video?.id,
            timeLimit: form.fields.timeLimit,
            passingScore: form.fields.passingScore,
            status: "draft",
        });
    };

    return (
        <PageLayout title="Новый тест">
            <QuizForm
                form={form}
                ckEditor={ckEditor}
                isSavingProgress={isSavingProcess}
                categoriesList={categoryList}
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
