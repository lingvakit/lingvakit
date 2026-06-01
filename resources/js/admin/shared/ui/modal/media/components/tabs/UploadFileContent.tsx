import {ChangeEvent, FormEvent, useState} from "react";

type Props = {
    isUploading: boolean;
    onSubmit: (file: File) => Promise<void>;
};

export function UploadFileContent({
    isUploading,
    onSubmit
}: Props) {
    const [selectedFile, setSelectedFile] = useState<File | null>(null);

    const handleFileChange = (e: ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0] || null;
        setSelectedFile(file);
    };

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>
    ): Promise<void> => {
        e.preventDefault();

        if (!selectedFile) {
            return;
        }

        await onSubmit(selectedFile);
    };

    return (
        <div className="tab-pane fade show active">
            <form onSubmit={handleSubmit}>
                <div className="form-group row">
                    <div className="col-12 mb-3">
                        <label className="form-control-label">
                            Загрузка файла
                        </label>
                        <input
                            type="file"
                            name="file"
                            className="form-control"
                            onChange={handleFileChange}
                            disabled={isUploading}
                        />
                    </div>
                </div>

                <div className="text-right mt-3">
                    <button
                        className="btn btn-gradient-01"
                        type="submit"
                        disabled={isUploading || !selectedFile}
                    >
                        {isUploading ? "Загрузка..." : "Загрузить"}
                    </button>
                </div>
            </form>
        </div>
    );
}
