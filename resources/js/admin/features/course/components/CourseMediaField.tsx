import {MediaType} from "../../../shared/types/media";
import React from "react";

type Props = {
    imageId: number | null;
    videoId: number | null;
    audioId: number | null;
    onOpenMediaModal: (type: MediaType) => void;
};

export default function CourseMediaField({
    imageId,
    videoId,
    audioId,
    onOpenMediaModal
}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Медиафайлы
            </label>
            <div className="col-lg-9">
                {imageId && (
                    <div className="form-group preview">
                        <div className="current-item">
                            <img src="#" style={{width: 240}} alt=""/>
                            Image ID: {imageId}
                        </div>
                    </div>
                )}
                <button type="button"
                        className="btn btn-primary square mr-1 mb-2 btn-attach"
                        onClick={() => onOpenMediaModal('image')}
                >
                    Выбрать изображение
                </button>

                {videoId && (
                    <div className="form-group preview">
                        Video ID: {videoId}
                    </div>
                )}

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