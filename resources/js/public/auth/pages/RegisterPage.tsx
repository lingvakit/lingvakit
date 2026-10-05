import {useState} from 'react';
import {Link} from 'react-router-dom';
import {AuthLayout} from '../components/AuthLayout';
import {TextField} from '../components/TextField';
import {useAuthForm} from '../useAuthForm';

interface RegisterForm extends Record<string, string | boolean> {
    name: string;
    email: string;
    agreement: boolean;
    hp_company: string;
}

export default function RegisterPage() {
    const form = useAuthForm<RegisterForm>(
        {
            name: '',
            email: '',
            agreement: false,
            hp_company: ''
        },
        '/register',
        ['name', 'email', 'agreement']
    );
    const [sentTo, setSentTo] = useState<string | null>(null);

    async function onSubmit(e: React.FormEvent) {
        e.preventDefault();
        if (await form.submit()) setSentTo(form.values.email.trim());
    }

    if (sentTo) {
        return (
            <AuthLayout title="Проверьте почту"
                        subtitle={`Мы отправили письмо со ссылкой на ${sentTo}`}
                        footer={<Link to="/login">Перейти ко входу</Link>}>
                <div className="alert alert--success">
                    Перейдите по ссылке из письма и придумайте пароль. Ссылка действует 24 часа.
                    Не пришло — загляните в «Спам».
                </div>
            </AuthLayout>
        );
    }

    return (
        <AuthLayout
            title="Создание аккаунта"
            footer={<>Уже есть аккаунт? <Link to="/login">Войти</Link></>}
        >
            {form.formError && <div className="alert alert--error">{form.formError}</div>}

            <form onSubmit={onSubmit} noValidate>
                <TextField label="Имя" autoComplete="given-name" autoFocus
                           value={form.values.name} error={form.errors.name}
                           onChange={(v) => form.setValue('name', v)}/>
                <TextField label="Электронная почта" type="email" autoComplete="email"
                           value={form.values.email} error={form.errors.email}
                           onChange={(v) => form.setValue('email', v)}/>

                <input
                    className="hp"
                    name="hp_company"
                    tabIndex={-1}
                    autoComplete="off"
                    aria-hidden="true"
                    value={form.values.hp_company}
                    onChange={(e) => form.setValue('hp_company', e.target.value)}
                />

                <label className={`check${form.errors.agreement ? ' check--error' : ''}`}>
                    <input
                        type="checkbox"
                        checked={form.values.agreement}
                        onChange={(e) => form.setValue('agreement', e.target.checked)}
                    />
                    <span>Я принимаю{' '} <a href="/terms" target="_blank" rel="noreferrer">правила и условия сайта</a></span>
                </label>
                {form.errors.agreement && <small className="field__error">{form.errors.agreement}</small>}


                <button className="btn" disabled={form.processing || !form.values.agreement}>
                    {form.processing ? 'Создаём…' : 'Создать аккаунт'}
                </button>
            </form>
        </AuthLayout>
    );
}