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
            title: form.fields.title.trim(),
            description: form.fields.description,
            price: form.fields.price,
            duration: form.fields.duration,
            difficultyLevel: form.fields.difficultyLevel,
            paidType: form.fields.paidType,
            isNew: form.fields.isNew,
            isAllowed: true,
            categoryId: form.fields.categoryId,
            image: form.fields.media.image?.id,
            video: form.fields.media.video?.id,
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
                isOpen={form.handlers.isMediaModalOpen}
                mediaType={form.handlers.mediaType}
                onClose={form.handlers.closeMediaModal}
                onSelect={(file) => {
                    if (form.handlers.mediaTarget === "editor") {
                        ck.handleSelectMediaFile(file);
                    } else {
                        form.handlers.selectMediaFile(file);
                    }

                    form.handlers.closeMediaModal();
                }}
            />
        </PageLayout>
    );
}