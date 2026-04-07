import React from "react";
import {useCategoryList} from "../../../../entities/category/model/hooks";
import PageLayout from "../../../../widgets/layout/PageLayout";
import {useCreateCourse} from "../../../../entities/course/model/hooks";
import {useCourseCreateForm} from "../../../../features/course/create/model/useCourseCreateForm";
import CourseForm from "./components/CourseForm";
import MediaUploadModal from "../../../../shared/ui/modal/media/MediaUploadModal";
import {useCKEditor} from "../../../../shared/ui/modal/media/useCKEditor";

export default function CourseCreatePage() {
    const {categoryList, isLoading, error} = useCategoryList();
    const {create, isSaving, error: submitError, fieldErrors} = useCreateCourse();
    const form = useCourseCreateForm();
    const ck = useCKEditor();

    const handleSubmit = async (): Promise<void> => {
        await create({
            title: form.title.trim(),
            description: form.description,
            price: form.price,
            duration: form.duration,
            difficultyLevel: form.difficultyLevel,
            paidType: form.paidType,
            isNew: form.isNew,
            isAllowed: true,
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
                ck={ck}
                fieldErrors={fieldErrors}
            />

            <MediaUploadModal
                isOpen={form.isMediaModalOpen}
                mediaType={form.mediaType}
                onClose={form.handleCloseMediaModal}
                onSelect={(file) => {
                    if (form.mediaTarget === "editor") {
                        ck.handleSelectMediaFile(file);
                    } else {
                        form.handleSelectMediaFile(file);
                    }

                    form.handleCloseMediaModal();
                }}
            />
        </PageLayout>
    );
}