import PageLayout from "../../../../widgets/layout/PageLayout";
import {useLoaderData} from "react-router-dom";
import {Quiz} from "../../../../entities/quiz/model/types";

export function QuizDetailsPage() {
    const quiz = useLoaderData() as Quiz;

    return (
        <PageLayout title={quiz.title}>
            <h1>Quiz details page</h1>
        </PageLayout>
    );
}