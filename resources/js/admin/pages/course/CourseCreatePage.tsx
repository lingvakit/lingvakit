import React from "react";
import {useCategoryList} from "../../features/category/hooks/useCategoryList";
import {useCreateCourse} from "../../features/course/hooks/useCreateCourse";
import PageLayout from "../../layouts/PageLayout";
import MediaUploadModal from "../../shared/components/MediaUploadModal";
import {useCourseCreateForm} from "../../features/course/hooks/useCourseCreateForm";
import CourseForm from "../../features/course/components/CourseForm";

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