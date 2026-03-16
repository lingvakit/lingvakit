export type MediaType = "audio" | "image" | "video";

export type MediaFile = {
    id: number;
    fileName: string;
    type: MediaType;
    url: string;
};
