import {ChangeEvent} from "react";

type Props = {
    label: string;
    name: string;
    value: string;
    onChange: (e: ChangeEvent<HTMLInputElement>) => void
    isRequired?: boolean;
    placeholder?: string;
};

export function InputTextField({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                {label}
                {isRequired && <span className="text-danger ml-2">*</span>}
            </label>
            <div className="col-lg-9">
                <input
                    type="text"
                    name={name}
                    className="form-control"
                    placeholder={placeholder}
                    value={value}
                    onChange={onChange}
                />
            </div>
        </div>
    );
}