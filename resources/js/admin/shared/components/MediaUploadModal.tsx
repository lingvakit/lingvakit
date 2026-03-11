import {MediaFile, MediaType} from "../types/media";
import React from "react";
import BaseModal from "./BaseModal";

type Props = {
    isOpen: boolean,
    mediaType: MediaType,
    onClose: () => void,
    onSelect: (file: MediaFile) => void,
};

export default function MediaUploadModal({isOpen, mediaType, onClose, onSelect}: Props) {
    return (
        <BaseModal
            isOpen={isOpen}
            title={`Загрузка медиа файлов (${mediaType})`}
            onClose={onClose}
        >
            <input
                id="search"
                className="form-control mb-3"
                type="search"
                name="search"
                placeholder="Поиск файла по названию"
            />

            <ul className="nav nav-tabs" role="tablist">
                <li className="nav-item">
                    <a
                        className="nav-link choose-aria active"
                        id="choosing-tab"
                        data-toggle="tab"
                        href="#choosing-area"
                        role="tab"
                        aria-controls="choosing-area"
                        aria-selected="true"
                    >
                        <i className="ion-image mr-2"></i>
                        Выбрать
                    </a>
                </li>
                <li className="nav-item">
                    <a
                        className="nav-link"
                        id="uploading-tab"
                        data-toggle="tab"
                        href="#uploading-area"
                        role="tab"
                        aria-controls="uploading-area"
                        aria-selected="false"
                    >
                        <i className="ion-archive mr-2"></i>
                        Загрузить
                    </a>
                </li>
            </ul>

            <div className="tab-content pt-3">
                <div className="tab-pane fade show active" id="choosing-area" role="tabpanel"
                     aria-labelledby="choosing-tab">

                    <div
                        id="media-loader"
                        className="text-center py-4"
                        style={{display: 'none'}}
                    >
                        <div className="spinner-border text-primary"></div>
                        <div className="mt-2">Загрузка файлов…</div>
                    </div>

                    <div id="media-library" className="media-library row"></div>

                    <div className="text-center mt-3">
                        <button
                            id="load-more"
                            className="btn btn-outline-primary"
                            style={{display: 'none'}}
                        >Загрузить ещё</button>
                    </div>
                </div>
                <div className="tab-pane fade" id="uploading-area" role="tabpanel"
                     aria-labelledby="uploading-tab">
                    <form
                        id="form-upload"
                        action=""
                        method="POST"
                        encType="multipart/form-data"
                    >
                        <div className="form-group row">
                            <div className="col-12 mb-3">
                                <label className="form-control-label">
                                    Загрузка файла
                                </label>
                                <input
                                    type="file"
                                    name="filename[]"
                                    className="form-control"
                                    multiple
                                />
                            </div>
                        </div>
                        <div className="alert alert-success hide"></div>

                        <div className="text-right mt-3">
                            <button
                                id="upload-files"
                                className="btn btn-gradient-01"
                                type="submit"
                            >Загрузить</button>
                        </div>
                    </form>
                </div>
            </div>
        </BaseModal>
    );
}