import React from "react";
import {difficultyLevels} from "../constants/difficultyLevels";

type Props = {
    value: string;
    onChange: React.ChangeEventHandler<HTMLInputElement>;
};

export default function CourseDifficultyField({value, onChange}: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Уровень сложности
            </label>
            <div className="col-lg-9">
                <div className="row">
                    {difficultyLevels.map((level) => (
                        <div
                            key={`difficulty_level_${level.value}`}
                            className="col-xl-2"
                        >
                            <div className="mb-3">
                                <div className="styled-radio">
                                    <input
                                        type="radio"
                                        name="difficulty_level"
                                        id={level.value}
                                        value={level.value}
                                        checked={value === level.value}
                                        onChange={onChange}
                                    />
                                    <label htmlFor={level.value}>
                                        {level.label}
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