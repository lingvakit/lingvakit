import {ChangeEvent} from "react";

type Props = {
    label: string,
    name: string,
    value: string,
    onChange: (e: ChangeEvent<HTMLTextAreaElement>) => void,
    isRequired?: boolean,
    placeholder?: string,
    rows?: number,
};

export function VerticalTextareaField ({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
    rows
}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <div className="col-12">
                <label className="form-control-label">
                    {label}
                    {isRequired && <span className="text-danger ml-2">*</span>}
                </label>
                <textarea
                    name={name}
                    rows={rows}
                    className="form-control"
                    placeholder={placeholder}
                    value={value ?? ''}
                    onChange={onChange}
                />
            </div>
        </div>
    );
}
