import { MediaFile, MediaType } from "../../../../../../entities/media/model/types";
import MediaList from "../MediaList";
import { useState } from "react";
import { useMediaList } from "../../../../../../entities/media/model/hooks";

type Props = {
    mediaType: MediaType,
    onSelect: (file: MediaFile) => void,
};

export function FileSelectionContent({
    mediaType,
    onSelect
}: Props) {
    const [currentMediaType, setCurrentMediaType] = useState<MediaType>(mediaType);

    const {
        mediaFiles,
        loading,
        page,
        setPage,
        paginatorMeta,
        query,
        setQuery
    } = useMediaList(currentMediaType);

    const handleLoadMoreFiles = (): void => {
        if (!loading) {
            setPage(page + 1);
        }
    };

    const handleTabChange = (type: MediaType) => {
        setCurrentMediaType(type);
        setPage(1);
    };

    const hasMorePages = paginatorMeta ? page < paginatorMeta.last_page : false;

    const isInitialLoading = loading && page === 1;
    const isAppending = loading && page > 1;

    return (
        <div className="tab-pane fade show active">
            <div className="mb-3">
                <input
                    type="search"
                    className="form-control"
                    placeholder="Поиск по названию файла..."
                    value={query}
                    onChange={(e) => setQuery(e.target.value)}
                />
            </div>

            <div className="mt-1 mb-4 btn-group">
                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "image" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => handleTabChange('image')}
                >Изображения</button>

                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "audio" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => handleTabChange('audio')}
                >Аудио</button>

                <button
                    type="button"
                    className={`mr-1 btn btn-sm btn-square ${currentMediaType === "video" ? 'btn-dark' : 'btn-outline-secondary'}`}
                    onClick={() => handleTabChange('video')}
                >Видео</button>
            </div>

            <MediaList
                mediaFiles={mediaFiles}
                onSelect={onSelect}
                isLoading={isInitialLoading}
            />

            {hasMorePages && (
                <div className="text-center mt-3 pb-3">
                    <button
                        id="load-more"
                        className="btn btn-outline-primary"
                        onClick={handleLoadMoreFiles}
                        disabled={loading}
                    >
                        {isAppending ? (
                            <>
                                <span
                                    className="spinner-border spinner-border-sm mr-2"
                                    role="status"
                                    aria-hidden="true"
                                ></span>
                                Загрузка...
                            </>
                        ) : (
                            "Загрузить еще"
                        )}
                    </button>
                </div>
            )}
        </div>
    );
}
