import {COMPANY_NAME, LOGO_SRC} from '../config';

export function AuthLogo() {
    return (
        <a href="/" className="auth__logo" aria-label={`${COMPANY_NAME} — на главную`}>
            <img src={LOGO_SRC} alt={COMPANY_NAME} height={48}/>
        </a>
    );
}