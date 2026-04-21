type Props = {
    title: string;
};

export function CourseTag({title}: Props) {
    return (
        <button
            type="button"
            className="btn btn-outline-primary btn-sm mr-3"
        >{title}</button>
    );
}