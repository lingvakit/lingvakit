import BaseModal from "../BaseModal";
import {FormEvent, useEffect, useState} from "react";
import {useLessonForm} from "../../../../features/lesson/create/model/useLessonForm";
import {DifficultyLevel} from "../../../../entities/lesson/model/types";
import {useAiGenerateMessage} from "../../../../entities/ai/model/hooks";

type Props = {
    lessonTheme: string;
    isOpen: boolean;
    onClose: () => void;
    form: ReturnType<typeof useLessonForm>
};

export function AiLessonContentFormModal({
    lessonTheme,
    isOpen,
    onClose,
    form
}: Props) {
    const [title, setTitle] = useState('');
    const [difficultyLevel, setDifficultyLevel] = useState<DifficultyLevel>('hard');
    const difficultyLevelOptions = [
        {label: "Hard", value: "hard"},
        {label: "HSK-1", value: "hsk1"},
        {label: "HSK-2", value: "hsk2"},
        {label: "HSK-3", value: "hsk3"},
    ];
    const [lessonContent, setLessonContent] = useState<string | null>('');

    useEffect(() => {
        setTitle(lessonTheme ?? '');
    }, [lessonTheme]);

    const {
        execute,
    } = useAiGenerateMessage();

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>,
    ): Promise<void> => {
        e.preventDefault();

        const prompt = `Подготовь контент для урока по китайскому языку на тему "${title}". Уровень сложности - HSK-1. Раздели урок на небольшие абзацы, по 2-3 предложения. Общий объем контента должен быть примерно на 2000 символов.`;

        const response = await execute({
            messages: [
                {
                    content: prompt,
                    role: "user"
                }
            ]
        });

        setLessonContent(response);
    };

    const handleAcceptContentFromAi = () => {
        if (lessonContent && lessonContent.length > 0) {
            form.handlers.setDescription(lessonContent);
        }

        onClose();
    };

    return (
        <BaseModal
            title="Генерация урока с помощью AI"
            isOpen={isOpen}
            onClose={onClose}
        >
            <form
                className="form-horizontal"
                onSubmit={handleSubmit}
            >
                <div className="form-group">
                    <div className="col-12 mb-3">
                        <label className="form-control-label">
                            Тема урока
                            <span className="text-danger ml-2">*</span>
                        </label>

                        <input
                            type="text"
                            name="title"
                            className="form-control"
                            placeholder="Модуль 1"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                        />
                    </div>
                </div>

                <div className="form-group">
                    <div className="col-12 mb-3">
                        <label className="form-control-label">
                            Сложность урока
                            <span className="text-danger ml-2">*</span>
                        </label>

                        <select
                            name="difficulty"
                            className="custom-select form-control"
                            value={difficultyLevel}
                            onChange={(e) => setDifficultyLevel(
                                e.target.value as DifficultyLevel
                            )}
                        >
                            {difficultyLevelOptions.map((level) => (
                                <option
                                    key={`level_${level.value}`}
                                    value={level.value}
                                >{level.label}</option>
                            ))}
                        </select>
                    </div>
                </div>

                {lessonContent && (
                    <div className="form-group">
                        <div className="col-12 mb-3">
                            <label className="form-control-label">
                                ИИ контент
                            </label>

                            <textarea
                                className="form-control"
                                value={lessonContent}
                                rows={20}
                                readOnly={true}
                            />
                        </div>
                    </div>
                )}

                <div className="form-group">
                    <div className="col-12 mb-3">
                        <button
                            className="btn btn-gradient-01 mr-2"
                            type="submit"
                        >Генерировать
                        </button>

                        <button
                            className="btn btn-gradient-02"
                            type="button"
                            onClick={handleAcceptContentFromAi}
                        >Принять результат</button>
                    </div>
                </div>
            </form>
        </BaseModal>
    );
}
