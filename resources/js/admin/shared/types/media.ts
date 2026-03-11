export type MediaType = "audio" | "image" | "video";

export type MediaFile = {
    id: number;
    url: string;
    previewUrl?: string;
    type: MediaType;
    title: string;
};