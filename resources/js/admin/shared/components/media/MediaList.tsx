import React from "react";
import {MediaFile} from "../../../features/media/types/mediaFile";

type Props = {
    mediaFiles: MediaFile[];
    onSelect: (mediaFile: MediaFile) => void;
}

export default function MediaList({ mediaFiles, onSelect }: Props) {
    if (!mediaFiles.length) {
        return <div className="text-center py-4">Файлы не найдены</div>;
    }

    return (
        <div className="media-library row">
            {mediaFiles.map((mediaFile) => (
                <div
                    key={mediaFile.id}
                    className="col-4"
                >
                    <div className="file-wrap exists-file mt-2 mb-2">
                        <img
                            src={mediaFile.url}
                            alt={mediaFile.fileName ?? "media"}
                            loading="lazy"
                        />
                    </div>
                </div>
            ))}
        </div>
    );
}
