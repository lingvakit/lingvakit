export type MediaType = "audio" | "image" | "video" | "file";

export type MediaFile = {
    id: number,
    fileName: string,
    type: MediaType,
    url: string,
};

export type MediaFilePayload = {
    file: File,
    title?: string|null,
    altText?: string|null,
};
