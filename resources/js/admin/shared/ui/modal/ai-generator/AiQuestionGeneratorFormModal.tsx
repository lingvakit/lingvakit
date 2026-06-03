import BaseModal from "../BaseModal";
import {FormEvent, useEffect} from "react";
import {InputTextField} from "../../form/InputTextField";
import {InputNumberField} from "../../form/InputNumberField";
import {TextareaField} from "../../form/TextareaField";
import {useAiQuestionForm} from "../../../hooks/useAiQuestionForm";
import {useAiGenerateQuestions} from "../../../../entities/ai/model/hooks";

type Props = {
    theme: string,
    isOpen: boolean,
    onClose: () => void,
};

export function AiQuestionGeneratorFormModal({
    theme,
    isOpen,
    onClose
}: Props) {
    const form = useAiQuestionForm({theme});

    useEffect(() => {
        form.setFieldValue("theme", theme);
    }, [theme]);

    const {
        execute,
        isProcessing
    } = useAiGenerateQuestions();

    const handleSubmit = async (
        e: FormEvent<HTMLFormElement>,
    ): Promise<void> => {
        e.preventDefault();

        /* TODO: Open this code after response will be tested */
        // const systemPrompt = `Ты — профессиональный преподаватель китайского языка и составитель тестов. Твоя задача — генерировать проверочные вопросы. Твой ответ должен быть ИСКЛЮЧИТЕЛЬНО в формате валидного JSON. Никакого приветствия, текста до или после JSON. Не используй markdown-разметку, возвращай только чистый JSON-объект.`;
        // const userPrompt = `Сгенерируй 2 вопроса по китайскому языку на тему: \\"Веселый китайский язык для детей от 7 лет\\".\\n\\nТребования к вопросам:\\n1. Каждый вопрос должен содержать сам вопрос (иероглифы + пиньинь + перевод на русский).\\n2. У каждого вопроса должно быть ровно 4 варианта ответа.\\n3. Только один вариант должен быть правильным.\\n4. Для каждого вопроса добавь краткое объяснение правильного ответа.\\n\\nОтвет должен строго соответствовать следующей JSON-структуре:\\n{\\n \\"topic\\": \\"{ТЕМА_ДЛЯ_ГЕНЕРАЦИИ}\\",\\n \\"questions\\": [\\n {\\n \\"id\\": 1,\\n \\"question\\": \\"Текст вопроса (иероглифы + пиньинь + русский)\\",\\n \\"options\\": [\\n {\\"id\\": \\"A\\", \\"text\\": \\"Вариант ответа 1\\"},\\n {\\"id\\": \\"B\\", \\"text\\": \\"Вариант ответа 2\\"},\\n {\\"id\\": \\"C\\", \\"text\\": \\"Вариант ответа 3\\"},\\n {\\"id\\": \\"D\\", \\"text\\": \\"Вариант ответа 4\\"}\\n ],\\n \\"correct_answer_id\\": \\"A\\",\\n \\"explanation\\": \\"Объяснение правильного ответа...\\"\\n }\\n ]\\n}`;

        // const response = await execute({
        //     messages: [
        //         {
        //             content: systemPrompt,
        //             role: "system"
        //         },
        //         {
        //             content: userPrompt,
        //             role: "user"
        //         }
        //     ]
        // });


        const responseExample = "{\"topic\": \"Веселый китайский язык для детей от 7 лет\", \"questions\": [{\"id\": 1, \"question\": \"zhī zhū zuò shénme？(Что делает обезьяна?)\", \"options\": [{\"id\": \"A\", \"text\": \"chī jiǎo 吃糍饨(есть цзяньао)\"}, {\"id\": \"B\", \"text\": \"wán yóuyǒu 玩游圈(играть с мячиком)\"}, {\"id\": \"C\", \"text\": \"pāi shēnggān 拍棕肩(бить по плечу)\"}, {\"id\": \"D\", \"text\": \"zài shùshāng 在树上(сидеть на дереве)\"}], \"correct_answer_id\": \"D\", \"explanation\": \"Правильный ответ D, потому что 'zài shùshang' означает 'на дереве', а обезьяны часто изображаются сидящими на деревьях.\"}, {\"id\": 2, \"question\": \"māma shuō nǐ hěn dàojiàng. (Мама сказала, что ты очень...)\", \"options\": [{\"id\": \"A\", \"text\": \"xiǎoxìng 小心翼翼(осторожный)\"}, {\"id\": \"B\", \"text\": \"yǒuxiǎn 愚钝(глупый)\"}, {\"id\": \"C\", \"text\": \"dàojiàng 勇敢(смелый)\"}, {\"id\": \"D\", \"text\": \"guāngjìng 光荣(гордый)\"}], \"correct_answer_id\": \"C\", \"explanation\": \"Правильный ответ C, так как 'dàojiàng' означает 'смелый'. Мама обычно хвалит ребенка за смелость.\"}]}";
        const data = JSON.parse(responseExample);

        console.log(data);
    }

    return (
        <BaseModal
            title="ИИ генератор вопросов для теста"
            isOpen={isOpen}
            onClose={onClose}
        >
            <form
                className="form-horizontal"
                onSubmit={handleSubmit}
            >
                <InputTextField
                    label="Тематика вопросов"
                    name="theme"
                    value={form.fields.theme}
                    onChange={form.handlers.changeText}
                    placeholder="Достопримечательности Шанхая"
                    isRequired={true}
                    isVertical={true}
                />

                <TextareaField
                    label="Детальное описание задания для ИИ"
                    name="description"
                    value={form.fields.description}
                    onChange={form.handlers.changeText}
                    placeholder="Опишите подробное задание для более точной генерации вопросов (не обязательное поле)"
                    isVertical={true}
                />

                <InputNumberField
                    label="Количество вопросов"
                    name="questionsQty"
                    value={form.fields.questionsQty}
                    onChange={form.handlers.changeNumber}
                    isRequired={true}
                    isVertical={true}
                    minDigit={1}
                    maxDigit={10}
                />

                <InputNumberField
                    label="Количество вариантов ответа"
                    name="questionOptionsQty"
                    value={form.fields.questionOptionsQty}
                    onChange={form.handlers.changeNumber}
                    isRequired={true}
                    isVertical={true}
                    minDigit={2}
                    maxDigit={6}
                />

                <div className="form-group">
                    <div className="col-12 mb-3">
                        <button
                            className="btn btn-gradient-01 mr-2"
                            type="submit"
                            disabled={isProcessing}
                        >{isProcessing
                            ? 'Генерирую вопросы ...'
                            : 'Генерировать вопросы'
                        }</button>
                    </div>
                </div>
            </form>
        </BaseModal>
    );
}
