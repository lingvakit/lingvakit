import {useState} from 'react';
import {Link} from 'react-router-dom';
import {AuthLayout} from '../components/AuthLayout';
import {TextField} from '../components/TextField';
import {useAuthForm} from '../useAuthForm';

export default function ForgotPasswordPage() {
    const form = useAuthForm({email: ''}, '/forgot-password');
    const [sent, setSent] = useState(false);

    async function onSubmit(e: React.FormEvent) {
        e.preventDefault();
        if (await form.submit()) setSent(true);
    }

    return (
        <AuthLayout title="Восстановление пароля"
                    subtitle="Укажите почту — отправим ссылку для установки нового пароля."
                    footer={<Link to="/login">Вернуться ко входу</Link>}>
            {sent ? (
                // Текст фиксированный: не раскрываем, есть ли такой email в системе
                <div className="alert alert--success">
                    Если аккаунт с такой почтой существует, мы отправили на неё письмо со ссылкой.
                </div>
            ) : (
                <form onSubmit={onSubmit} noValidate>
                    {form.formError && <div className="alert alert--error">{form.formError}</div>}
                    <TextField label="Электронная почта" type="email" autoComplete="email" autoFocus
                               value={form.values.email} error={form.errors.email}
                               onChange={(v) => form.setValue('email', v)}/>
                    <button className="btn" disabled={form.processing}>
                        {form.processing ? 'Отправляем…' : 'Отправить ссылку'}
                    </button>
                </form>
            )}
        </AuthLayout>
    );
}