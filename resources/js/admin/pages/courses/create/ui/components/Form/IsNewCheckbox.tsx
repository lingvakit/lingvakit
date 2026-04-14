import React from "react";

type Props = {
    value: boolean,
    onChange: React.ChangeEventHandler<HTMLInputElement>
};

export default function IsNewCheckbox({ value, onChange }: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Это новый курс?
            </label>
            <div className="col-lg-9">
                <div className="row">
                    <div className="col-xl-2">
                        <div className="mb-3">
                            <div className="styled-checkbox">
                                <input
                                    type="checkbox"
                                    name="isNew"
                                    id="isNew"
                                    value="true"
                                    checked={value}
                                    onChange={onChange}
                                />
                                <label htmlFor="isNew">
                                    Да
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}