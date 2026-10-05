import {Link, useNavigate, useParams, useSearchParams} from 'react-router-dom';
import {AuthLayout} from '../components/AuthLayout';
import {TextField} from '../components/TextField';
import {useAuthForm} from '../useAuthForm';

export default function ResetPasswordPage() {
    const {token = ''} = useParams();
    const [params] = useSearchParams();
    const navigate = useNavigate();

    const isWelcome = params.get('welcome') === '1';

    const form = useAuthForm({password: '', password_confirmation: ''}, '/reset-password');

    async function onSubmit(e: React.FormEvent) {
        e.preventDefault();
        const ok = await form.submit({token, email: params.get('email') ?? ''});
        if (ok) {
            navigate('/login', {
                state: {
                    status: isWelcome
                        ? 'Пароль создан. Теперь можно войти.'
                        : 'Пароль изменён. Войдите с новым паролем.',
                },
            });
        }
    }

    // Ошибки токена/email приходят по ключам, которых нет в видимых полях
    const linkError = form.errors.email ?? form.errors.token;

    return (
        <AuthLayout
            title={isWelcome ? 'Придумайте пароль' : 'Новый пароль'}
            subtitle={isWelcome ? 'Последний шаг: задайте пароль для входа в аккаунт.' : undefined}
            footer={<Link to="/login">Вернуться ко входу</Link>}
        >
            {(linkError || form.formError) && (
                <div className="alert alert--error">
                    {linkError ?? form.formError} <Link to="/forgot-password">Запросить новую ссылку</Link>
                </div>
            )}
            <form onSubmit={onSubmit} noValidate>
                <TextField label="Новый пароль" type="password" autoComplete="new-password" autoFocus
                           value={form.values.password} error={form.errors.password}
                           onChange={(v) => form.setValue('password', v)}/>
                <TextField label="Повторите пароль" type="password" autoComplete="new-password"
                           value={form.values.password_confirmation}
                           onChange={(v) => form.setValue('password_confirmation', v)}/>
                <button className="btn" disabled={form.processing}>
                    {form.processing ? 'Сохраняем…' : 'Сохранить пароль'}
                </button>
            </form>
        </AuthLayout>
    );
}