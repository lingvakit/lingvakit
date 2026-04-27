export type MediaType = "audio" | "image" | "video" | "file";

export type MediaFile = {
    id: number;
    fileName: string;
    type: MediaType;
    url: string;
};
