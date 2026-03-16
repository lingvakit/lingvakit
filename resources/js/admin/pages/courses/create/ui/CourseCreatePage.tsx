import React from "react";
import { useCategoryList } from "../../../../entities/category/model/hooks";
import PageLayout from "../../../../widgets/layout/PageLayout";
import { useCreateCourse } from "../../../../entities/course/model/hooks";
import { useCourseCreateForm } from "../../../../features/course/create/model/useCourseCreateForm";
import CourseForm from "./components/CourseForm";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";

export default function CourseCreatePage() {
    const {categoryList, isLoading, error} = useCategoryList();
    const {create, isSaving, error: submitError} = useCreateCourse();
    const form = useCourseCreateForm();

    const handleSubmit = async (): Promise<void> => {
        await create({
            title: form.title.trim(),
            description: form.description,
            price: form.price,
            duration: form.duration,
            difficultyLevel: form.difficultyLevel,
            categoryId: form.categoryId,
            image: form.image?.id,
            video: form.video?.id,
        });
    };

    if (isLoading) {
        return <>Загрузка категорий...</>;
    }

    if (error) {
        return <>Ошибка: {error}</>;
    }

    return (
        <PageLayout title="Новый курс">
            <CourseForm
                categoryList={categoryList}
                submitError={submitError}
                isSaving={isSaving}
                form={form}
                onSubmit={handleSubmit}
            />

            <MediaUploadModal
                isOpen={form.isMediaModalOpen}
                mediaType={form.mediaType}
                onClose={form.handleCloseMediaModal}
                onSelect={form.handleSelectMediaFile}
            />
        </PageLayout>
    );
}