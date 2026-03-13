import React from "react";
import {MediaFile, MediaType} from "../../media/types/mediaFile.ts";

type Props = {
    image: MediaFile | null;
    video: MediaFile | null;
    audio: MediaFile | null;
    onOpenMediaModal: (type: MediaType) => void;
};

export default function CourseMediaField({
    image,
    video,
    audio,
    onOpenMediaModal
}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Медиафайлы
            </label>
            <div className="col-lg-9">
                {image && (
                    <div className="form-group preview">
                        <div className="current-item">
                            <img src={image.url} style={{width: 240}} alt=""/>
                        </div>
                        <input
                            type="hidden"
                            name="image"
                            value={image.id}
                        />
                    </div>
                )}

                {video && (
                    <div className="form-group preview">
                        <video
                            src={video.url}
                            style={{width: 240}}
                            controls
                        />
                        <input
                            type="hidden"
                            name="video"
                            value={video.id}
                        />
                    </div>
                )}

                <button type="button"
                        className="btn btn-primary square mr-1 mb-2 btn-attach"
                        onClick={() => onOpenMediaModal('image')}
                >
                    Выбрать изображение
                </button>

                <button type="button"
                        className="btn btn-primary square mr-1 mb-2 btn-attach"
                        onClick={() => onOpenMediaModal('video')}
                >
                    Выбрать видео
                </button>
            </div>
        </div>
    );
}