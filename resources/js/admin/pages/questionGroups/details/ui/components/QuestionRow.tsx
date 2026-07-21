import {Question} from "../../../../../entities/question/model/types";
import {QuestionOption} from "../../../../../entities/questionOption/model/types";

type Props = {
    question: Question,
    isUpdating: boolean,
    onChangeCorrectOption: (questionUuid: string, optionUuid: string) => Promise<void>
};

export default function QuestionRow({
    question,
    isUpdating,
    onChangeCorrectOption
}: Props) {
    const currentAnswerUuid = question.answer?.value?.[0];

    return (
        <>
            <tr className="text-primary header">
                <td style={{ width: "70%" }}>
                    <h4>{question.text}</h4>
                </td>
                <td className="td-actions text-right">
                    <a href="#"><i
                        className="la la-edit edit"></i></a>
                    <a href="#">
                        <i className="la la-close delete"></i>
                    </a>
                </td>
            </tr>

            {question.options.map((option: QuestionOption) =>(
                <tr
                    key={option.uuid}
                    className="border-bottom"
                >
                    <td
                        className="text-primary"
                        style={{ width: "50%"}}
                    >{option.text}</td>

                    <td>
                        <div className="styled-radio">
                            <input
                                type="radio"
                                name={`question_${question.uuid}`}
                                id={`option_${option.uuid}`}
                                value={option.uuid}
                                checked={currentAnswerUuid === option.uuid}
                                disabled={isUpdating}
                                onChange={() => onChangeCorrectOption(question.uuid, option.uuid)}
                            />
                            <label htmlFor={`option_${option.uuid}`}>Верно</label>
                        </div>
                    </td>
                </tr>
            ))}
        </>
    );
}
