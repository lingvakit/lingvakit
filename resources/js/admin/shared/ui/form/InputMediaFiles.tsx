import {MediaFile, MediaType} from "../../../entities/media/model/types";
import {MediaTarget} from "../modal/media/types";

type Props = {
    mediaFiles: {
        audio: MediaFile | null;
        image: MediaFile | null;
        video: MediaFile | null;
    };
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
};

export function InputMediaFiles({
    mediaFiles,
    onOpenMediaModal
}: Props) {
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
                            name="audio"
                            value={mediaFiles.audio.id}
                        />
                    </div>
                )}

                {mediaFiles.image && (
                    <div className="form-group preview">
                        <div className="current-item">
                            <img src={mediaFiles.image.url} style={{width: 240}} alt=""/>
                        </div>
                        <input
                            type="hidden"
                            name="image"
                            value={mediaFiles.image.id}
                        />
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
                            name="video"
                            value={mediaFiles.video.id}
                        />
                    </div>
                )}

                <button
                    type="button"
                    className="btn btn-primary square mr-1 mb-2 btn-attach"
                    onClick={() => onOpenMediaModal("form", "audio")}
                >Выбрать аудио файл</button>

                <button
                    type="button"
                    className="btn btn-primary square mr-1 mb-2 btn-attach"
                    onClick={() => onOpenMediaModal("form","image")}
                >Выбрать изображение</button>

                <button
                    type="button"
                    className="btn btn-primary square mr-1 mb-2 btn-attach"
                    onClick={() => onOpenMediaModal("form","video")}
                >Выбрать видео</button>
            </div>
        </div>
    );
}