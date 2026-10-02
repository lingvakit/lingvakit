import {Link, useLocation} from 'react-router-dom';
import {AuthLayout} from '../components/AuthLayout';
import {TextField} from '../components/TextField';
import {useAuthForm} from '../useAuthForm';

export default function LoginPage() {
    // сообщение после успешного сброса пароля передаётся через router state
    const status = (useLocation().state as {status?: string} | null)?.status;
    const form = useAuthForm({email: '', password: '', remember: true}, '/login');

    async function onSubmit(e: React.FormEvent) {
        e.preventDefault();
        const res = await form.submit<{redirect: string}>();
        if (res) window.location.assign(res.redirect); // полная перезагрузка: сессия/CSRF обновились
    }

    return (
        <AuthLayout
            title="Вход в аккаунт"
            footer={<>Нет аккаунта? <Link to="/register">Зарегистрироваться</Link></>}
        >
            {status && <div className="alert alert--success">{status}</div>}
            {form.formError && <div className="alert alert--error">{form.formError}</div>}

            <form onSubmit={onSubmit} noValidate>
                <TextField label="Электронная почта" type="email" autoComplete="email" autoFocus
                           value={form.values.email} error={form.errors.email}
                           onChange={(v) => form.setValue('email', v)}/>
                <TextField label="Пароль" type="password" autoComplete="current-password"
                           value={form.values.password} error={form.errors.password}
                           onChange={(v) => form.setValue('password', v)}/>

                <div className="row">
                    <label className="check">
                        <input type="checkbox" checked={form.values.remember}
                               onChange={(e) => form.setValue('remember', e.target.checked)}/>
                        Запомнить меня
                    </label>
                    <Link to="/forgot-password">Забыли пароль?</Link>
                </div>

                <button className="btn" disabled={form.processing}>
                    {form.processing ? 'Входим…' : 'Войти'}
                </button>
            </form>
        </AuthLayout>
    );
}