import { MediaFile } from "../../../../../entities/media/model/types";
import {SkeletonMediaList} from "./SkeletonMediaList";

type Props = {
    mediaFiles: MediaFile[],
    onSelect: (mediaFile: MediaFile) => void,
    isLoading: boolean
}

export default function MediaList({
    mediaFiles,
    onSelect,
    isLoading
}: Props) {
    if (isLoading) {
        return <SkeletonMediaList />
    }

    if (!mediaFiles.length) {
        return <div className="text-center py-4">Файлы не найдены</div>;
    }

    return (
        <div className="media-library row">
            {mediaFiles.map((mediaFile) => (
                <div
                    key={mediaFile.id}
                    className="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 mb-2"
                >
                    <div
                        className="file-wrap exists-file"
                        onClick={() => onSelect(mediaFile)}
                    >
                        {mediaFile.type === "image" && (
                            <img
                                src={mediaFile.url}
                                alt={mediaFile.fileName ?? "image"}
                                loading="lazy"
                            />
                        )}

                        {mediaFile.type === "video" && (
                            <video
                                src={mediaFile.url}
                                style={{width: '100%'}}
                                controls
                            />
                        )}

                        <h6 className="text-center">
                            {mediaFile.fileName}
                        </h6>
                    </div>
                </div>
            ))}
        </div>
    );
}
