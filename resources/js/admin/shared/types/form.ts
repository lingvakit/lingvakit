import { MediaFile } from "@admin/entities/media/model/types";

export type MediaFields = {
    audio: MediaFile | null;
    image: MediaFile | null;
    video: MediaFile | null;
};
