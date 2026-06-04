import {AiGeneratedQuestionsGroupPayload} from "../../../entities/questionGroup/model/types.ts";

export const getQuizSystemPrompt = (): string => {
    return `Ты — строгий API-сервер для образовательной платформы. Твоя задача — генерировать тестовые вопросы и возвращать их ИСКЛЮЧИТЕЛЬНО в формате валидного JSON.
Никакого приветствия, никаких рассуждений, никакого текста до или после JSON. Не используй markdown-разметку (без \`\`\`json). Верни только сырой JSON-объект.`;
};

export const getQuizUserPrompt = (
    theme: string,
    description: string,
    questionsQty: number,
    optionsQty: number
): string => {
    return `Сгенерируй ${questionsQty} вопроса(ов) по теме: "${theme}".
${description ? `Контекст: ${description}\n` : ''}
ЖЕСТКИЕ ТРЕБОВАНИЯ К СТРУКТУРЕ (КРИТИЧНО ВАЖНО):
1. Поле "question" должно содержать ТОЛЬКО сам текст вопроса (иероглифы + пиньинь + перевод). ЗАПРЕЩЕНО писать внутри поля "question" варианты ответа (A, B, C).
2. Варианты ответа должны лежать СТРОГО внутри массива "options". Каждый вариант — это отдельный объект с полями "id" и "text". Ровно ${optionsQty} варианта(ов).
3. Поля "correct_answer_id" и "explanation" должны быть заполнены отдельно, на одном уровне с "question".

Ожидаемый JSON-формат (СКОПИРУЙ ЭТУ СТРУКТУРУ):
{
  "topic": "${theme}",
  "questions": [
    {
      "id": 1,
      "question": "Текст вопроса (иероглифы + пиньинь + русский)",
      "options": [
        {"id": "A", "text": "Текст варианта 1"},
        {"id": "B", "text": "Текст варианта 2"},
        {"id": "C", "text": "Текст варианта 3"}
      ],
      "correct_answer_id": "B",
      "explanation": "Объяснение, почему вариант B правильный..."
    }
  ]
}`;
};

export const parseAiQuizResponse = (
    response: string
): AiGeneratedQuestionsGroupPayload => {
    const jsonMatch = response.match(/\{[\s\S]*\}/);

    if (!jsonMatch) {
        throw new Error("Не удалось найти JSON-структуру в ответе ИИ");
    }

    let cleanResponse = jsonMatch[0];
    cleanResponse = cleanResponse.replace(/,\s*([\]}])/g, '$1');

    return JSON.parse(cleanResponse) as AiGeneratedQuestionsGroupPayload;
};