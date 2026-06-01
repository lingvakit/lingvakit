import {MediaFile, MediaFilePayload} from "../../model/types";
import {baseApiUrl} from "../../../../shared/constants/api";
import {fetchMultipart} from "../../../../shared/api/fetchMultipart";

export async function uploadFile(
    data: MediaFilePayload
): Promise<MediaFile> {
    const uploadFileEndpoint = `${baseApiUrl}/media/upload`;

    const formData = new FormData();
    formData.append("file", data.file);

    if (data.title) {
        formData.append("title", data.title);
    }

    if (data.altText) {
        formData.append("altText", data.altText);
    }

    return fetchMultipart<MediaFile>(uploadFileEndpoint, {
        method: "POST",
        body: formData,
    });
}
