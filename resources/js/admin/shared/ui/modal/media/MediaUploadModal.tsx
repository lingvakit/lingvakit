import { MediaFile, MediaType } from "../../../../entities/media/model/types";
import BaseModal from "../BaseModal";
import {useState} from "react";
import {FileSelectionContent} from "./components/tabs/FileSelectionContent";
import {UploadFileContent} from "./components/tabs/UploadFileContent";
import {useUploadFile} from "../../../../entities/media/model/hooks";

type Props = {
    isOpen: boolean,
    mediaType: MediaType,
    onClose: () => void,
    onSelect: (file: MediaFile) => void,
};

type ModalArea = "fileSelection" | "fileUpload";

export default function MediaUploadModal({isOpen, mediaType, onClose, onSelect}: Props) {
    const [modalTitle, setModalTitle] = useState("Выбор файлов")
    const [modalArea, setModalArea] = useState<ModalArea>("fileSelection");

    const handleChangeToFileSelection = (): void => {
        setModalTitle("Выбор файлов");
        setModalArea("fileSelection");
    };

    const handleChangeToUploadArea = (): void => {
        setModalTitle("Загрузка файлов");
        setModalArea("fileUpload");
    };

    const {
        execute,
        isSavingProcess
    } = useUploadFile();

    const handleSubmit = async (file: File): Promise<void> => {
        await execute({file: file});

        handleChangeToFileSelection();
    };

    return (
        <BaseModal
            isOpen={isOpen}
            title={modalTitle}
            onClose={onClose}
        >
            <input
                id="search"
                className="form-control mb-3"
                type="search"
                name="search"
                placeholder="Поиск файла по названию"
            />

            <ul className="nav nav-tabs">
                <li className="nav-item">
                    <a
                        className={`nav-link ${modalArea === "fileSelection" ? "active" : ""}`}
                        onClick={handleChangeToFileSelection}
                    >
                        <i className="ion-image mr-2"></i>
                        Выбрать
                    </a>
                </li>

                <li className="nav-item">
                    <a
                        className={`nav-link ${modalArea === "fileUpload" ? "active" : ""}`}
                        onClick={handleChangeToUploadArea}
                    >
                        <i className="ion-archive mr-2"></i>
                        Загрузить
                    </a>
                </li>
            </ul>

            <div className="tab-content pt-3">
                {modalArea === "fileSelection" && (
                    <FileSelectionContent
                        mediaType={mediaType}
                        onSelect={onSelect}
                    />
                )}

                {modalArea === "fileUpload" && (
                    <UploadFileContent
                        isUploading={isSavingProcess}
                        onSubmit={handleSubmit}
                    />
                )}
            </div>
        </BaseModal>
    );
}
