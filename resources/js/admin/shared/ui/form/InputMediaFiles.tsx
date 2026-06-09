import {MediaType} from "../../../entities/media/model/types";
import {MediaTarget} from "../modal/media/types";
import {MouseEvent} from "react";
import {MODAL_IMAGE_THUMB_SIZE} from "../../../entities/media/model/constants";
import {MediaFields} from "../../types/form";

type Props = {
    target: MediaTarget,
    mediaFiles: MediaFields,
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void,
    onRemoveMediaFile: (target: MediaTarget, type: MediaType) => void,
};

export function InputMediaFiles({
    target,
    mediaFiles,
    onOpenMediaModal,
    onRemoveMediaFile
}: Props) {
    const removeMediaFileHandler = (
        e: MouseEvent<HTMLAnchorElement>,
        type: MediaType
    ): void => {
        e.preventDefault();
        onRemoveMediaFile(target, type);
    };

    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Медиафайлы
            </label>
            <div className="col-lg-9">
                {mediaFiles.audio && (
                    <div className="form-group preview">
                        <div className="current-item">
                            <audio src={mediaFiles.audio.url} controls />
                        </div>
                        <input
                            type="hidden"
                            name={`audio_${target}`}
                            value={mediaFiles.audio.id}
                        />
                        <div>
                            <a
                                href="#"
                                className="small"
                                onClick={(e) => removeMediaFileHandler(e, 'audio')}
                            >Удалить</a>
                        </div>
                    </div>
                )}

                {mediaFiles.image && (
                    <div className="form-group preview">
                        <div className="current-item">
                            <img
                                src={`${mediaFiles.image.url}?w=${MODAL_IMAGE_THUMB_SIZE}`}
                                style={{width: 240}}
                                alt={mediaFiles.image.fileName}
                            />
                        </div>
                        <input
                            type="hidden"
                            name={`image_${target}`}
                            value={mediaFiles.image.id}
                        />
                        <div>
                            <a
                                href="#"
                                className="small"
                                onClick={(e) => removeMediaFileHandler(e, 'image')}
                            >Удалить</a>
                        </div>
                    </div>
                )}

                {mediaFiles.video && (
                    <div className="form-group preview">
                        <video
                            src={mediaFiles.video.url}
                            style={{width: 240}}
                            controls
                        />
                        <input
                            type="hidden"
                            name={`video_${target}`}
                            value={mediaFiles.video.id}
                        />
                        <div>
                            <a
                                href="#"
                                className="small"
                                onClick={(e) => removeMediaFileHandler(e, 'video')}
                            >Удалить</a>
                        </div>
                    </div>
                )}

                <button
                    type="button"
                    className="btn btn-primary square mr-1 mb-2 btn-attach"
                    onClick={() => onOpenMediaModal(target, "image")}
                >Выбрать медиа файл</button>
            </div>
        </div>
    );
}
