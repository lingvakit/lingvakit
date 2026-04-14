import React from "react";

type Props = {
    value: string,
    onChange: React.ChangeEventHandler<HTMLInputElement>
};

const paidTypes = [
    {value: "paid", label: "Да"},
    {value: "free", label: "Нет"},
];

export default function SelectPaidTypeField({ value, onChange }: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Платный курс?
            </label>
            <div className="col-lg-9">
                <div className="row">
                    {paidTypes.map((type) => (
                        <div
                            key={`paidType_${type.value}`}
                            className="col-xl-2"
                        >
                            <div className="mb-3">
                                <div className="styled-radio">
                                    <input
                                        type="radio"
                                        name="paidType"
                                        id={type.value}
                                        value={type.value}
                                        checked={value === type.value}
                                        onChange={onChange}
                                    />
                                    <label htmlFor={type.value}>
                                        {type.label}
                                    </label>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}