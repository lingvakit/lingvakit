import React from "react";

type Props = {
    value: string;
    onChange: React.ChangeEventHandler<HTMLInputElement>;
};

const difficultyLevels = [
    { value: "beginner", label: "Простой" },
    { value: "intermediate", label: "Средний" },
    { value: "expert", label: "Сложный" },
];

export default function SelectDifficulty({ value, onChange }: Props) {
    return (
        <div className="form-group row d-flex align-items-center mb-5">
            <label className="col-lg-3 form-control-label">
                Уровень сложности
            </label>
            <div className="col-lg-9">
                <div className="row">
                    {difficultyLevels.map((level) => (
                        <div
                            key={`difficultyLevel_${level.value}`}
                            className="col-xl-2"
                        >
                            <div className="mb-3">
                                <div className="styled-radio">
                                    <input
                                        type="radio"
                                        name="difficultyLevel"
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