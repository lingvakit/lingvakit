import {ChangeEvent} from "react";

type Props = {
    label: string,
    name: string,
    value: number,
    onChange: (e: ChangeEvent<HTMLInputElement>) => void,
    isRequired?: boolean,
    placeholder?: string,
    minDigit?: number,
    maxDigit?: number,
};

export function VerticalNumberField({
    label,
    name,
    value,
    onChange,
    isRequired,
    placeholder,
    minDigit,
    maxDigit,
}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <div className="col-12">
                <label className="form-control-label">
                    {label}
                    {isRequired && <span className="text-danger ml-2">*</span>}
                </label>
                <input
                    type="number"
                    name={name}
                    className="form-control"
                    placeholder={placeholder ?? undefined}
                    value={value}
                    onChange={onChange}
                    min={minDigit ?? undefined}
                    max={maxDigit ?? undefined}
                />
            </div>
        </div>
    );
}