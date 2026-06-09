import {MediaFile} from "../../entities/media/model/types";

export type MediaFields = {
    audio: MediaFile|null,
    image: MediaFile|null,
    video: MediaFile|null,
};
