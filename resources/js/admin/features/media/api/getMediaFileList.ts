import {MediaFile} from "../types/mediaFile";

type MediaFileListResponse = {
    data: MediaFile[];
};

export async function getMediaFileList() {
    const response = await fetch('react/api/mediafiles', {
        method: 'GET',
        credentials: 'include',
        headers: {
            Accept: "application/json",
        }
    });

    if (!response.ok) {
        const text = await response.text();
        throw new Error(`HTTP ${response.status}: ${text.slice(0, 200)}`);
    }

    const json: MediaFileListResponse = await response.json();

    return json.data;
}
