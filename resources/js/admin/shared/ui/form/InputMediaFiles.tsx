import type { MediaType } from "@admin/entities/media/model/types";
import type { MediaTarget } from "../modal/media/types";
import type { MouseEvent } from "react";
import { MODAL_IMAGE_THUMB_SIZE } from "@admin/entities/media/model/constants";
import type { MediaFields } from "../../types/form";
import { FieldLayout } from "./FieldLayout";
import { useFieldControl } from "./useFieldControl";
import type { FieldErrorValue } from "./validation";

const PREVIEW_TYPES = [
    "audio",
    "image",
    "video",
] as const satisfies readonly MediaType[];
type PreviewType = (typeof PREVIEW_TYPES)[number];

type Props = {
    target: MediaTarget;
    mediaFiles: MediaFields;
    onOpenMediaModal: (target: MediaTarget, type: MediaType) => void;
    onRemoveMediaFile: (target: MediaTarget, type: MediaType) => void;
    error?: FieldErrorValue;
};

function MediaPreview({
    type,
    file,
}: {
    type: PreviewType;
    file: NonNullable<MediaFields[PreviewType]>;
}) {
    switch (type) {
        case "audio":
            return (
                <div className="current-item">
                    <audio src={file.url} controls />
                </div>
            );
        case "image":
            return (
                <div className="current-item">
                    <img
                        src={`${file.url}?w=${MODAL_IMAGE_THUMB_SIZE}`}
                        style={{ width: 240 }}
                        alt={file.fileName}
                    />
                </div>
            );
        case "video":
            return <video src={file.url} style={{ width: 240 }} controls />;
    }
}

export function InputMediaFiles({
    target,
    mediaFiles,
    onOpenMediaModal,
    onRemoveMediaFile,
    error,
}: Props) {
    const { errorId, hasError } = useFieldControl({ error });

    const removeMediaFileHandler = (
        e: MouseEvent<HTMLAnchorElement>,
        type: MediaType,
    ): void => {
        e.preventDefault();
        onRemoveMediaFile(target, type);
    };

    return (
        <FieldLayout label="Медиафайлы" error={error} errorId={errorId}>
            {PREVIEW_TYPES.map((type) => {
                const file = mediaFiles[type];

                if (!file) {
                    return null;
                }

                return (
                    <div key={type} className="form-group preview">
                        <MediaPreview type={type} file={file} />
                        <input
                            type="hidden"
                            name={`${type}_${target}`}
                            value={file.id}
                        />
                        <div>
                            <a
                                href="#"
                                className="small"
                                onClick={(e) => removeMediaFileHandler(e, type)}
                            >
                                Удалить
                            </a>
                        </div>
                    </div>
                );
            })}

            <button
                type="button"
                className="btn btn-primary square mr-1 mb-2 btn-attach"
                aria-describedby={hasError ? errorId : undefined}
                onClick={() => onOpenMediaModal(target, "image")}
            >
                Выбрать медиа файл
            </button>
        </FieldLayout>
    );
}
