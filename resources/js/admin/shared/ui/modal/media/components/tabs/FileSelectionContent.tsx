import {MediaFile, MediaType} from "../../../../../../entities/media/model/types";
import MediaList from "../MediaList";
import {useState} from "react";
import {useMediaList} from "../../../../../../entities/media/model/hooks";

type Props = {
    mediaType: MediaType,
    onSelect: (file: MediaFile) => void,
};

export function FileSelectionContent({
    mediaType,
    onSelect
}: Props) {
    const [currentMediaType, setCurrentMediaType] = useState<MediaType>(mediaType);
    const {mediaFiles} = useMediaList(currentMediaType);

    return (
        <div className="tab-pane fade show active">

            <div className="mt-1 mb-4 btn-group">
                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "image" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => setCurrentMediaType('image' as MediaType)}
                >Изображения</button>

                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "audio" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => setCurrentMediaType('audio' as MediaType)}
                >Аудио</button>

                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "video" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => setCurrentMediaType('video' as MediaType)}
                >Видео</button>
            </div>

            <div
                id="media-loader"
                className="text-center py-4"
                style={{display: 'none'}}
            >
                <div className="spinner-border text-primary"></div>
                <div className="mt-2">Загрузка файлов…</div>
            </div>

            <MediaList
                mediaFiles={mediaFiles}
                onSelect={onSelect}
            />

            <div className="text-center mt-3">
                <button
                    id="load-more"
                    className="btn btn-outline-primary"
                    style={{display: 'none'}}
                >Загрузить ещё</button>
            </div>
        </div>
    );
}