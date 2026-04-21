import DOMPurify from "dompurify";

type Props = {
    title: string;
    description?: string | null;
};

export function CourseProperty({title, description}: Props) {
    return (
        <div className="about-infos d-flex flex-column mb-3">
            <div className="about-title">
                <h5>{title}:</h5>
            </div>
            <div
                className="about-text"
                dangerouslySetInnerHTML={{
                    __html: DOMPurify.sanitize(description ?? ""),
                }}
            />
        </div>
    );
}