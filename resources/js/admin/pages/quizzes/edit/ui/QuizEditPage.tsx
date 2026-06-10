import {useLoaderData} from "react-router-dom";
import {Quiz} from "../../../../entities/quiz/model/types";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";
import {useQuizForm} from "../../../../features/quiz/model/useQuizForm";
import {useMediaModalManager} from "../../../../shared/ui/modal/media/useMediaModalManager";
import {MediaFile} from "../../../../entities/media/model/types";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {QuizForm} from "../../create/ui/components/QuizForm";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {useCategoryList} from "../../../../entities/category/model/hooks";
import {useUpdateQuiz} from "../../../../entities/quiz/model/hooks";
import {MediaTarget} from "../../../../shared/ui/modal/media/types";

export function QuizEditPage() {
    const quiz = useLoaderData() as Quiz;

    const {execute, isSavingProcess, error} = useUpdateQuiz();
    const ckEditor = useCKEditor();
    const {categoryList} = useCategoryList();
    const form = useQuizForm({
        title: quiz.title,
        description: quiz.description,
        timeLimit: quiz.timeLimit,
        passingScore: quiz.passingScore,
        mediaFiles: {
            audio: quiz.audioFile,
            image: quiz.imageFile,
            video: quiz.videoFile,
        },
    });

    const mediaModal = useMediaModalManager({
        onCKEditorSelect: ckEditor.handleSelectMediaFile,
        onFormSelect: (target: MediaTarget, file: MediaFile) => {
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