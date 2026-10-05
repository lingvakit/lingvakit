import {StrictMode, lazy, Suspense} from 'react';
import {createRoot} from 'react-dom/client';
import {BrowserRouter, Navigate, Route, Routes} from 'react-router-dom';
import './auth.css';

const LoginPage = lazy(() => import('./pages/LoginPage'));
const RegisterPage = lazy(() => import('./pages/RegisterPage'));
const ForgotPasswordPage = lazy(() => import('./pages/ForgotPasswordPage'));
const ResetPasswordPage = lazy(() => import('./pages/ResetPasswordPage'));

createRoot(document.getElementById('auth-root')!).render(
    <StrictMode>
        <BrowserRouter>
            <Suspense fallback={null}>
                <Routes>
                    <Route path="/login" element={<LoginPage/>}/>
                    <Route path="/register" element={<RegisterPage/>}/>
                    <Route path="/forgot-password" element={<ForgotPasswordPage/>}/>
                    <Route path="/reset-password/:token" element={<ResetPasswordPage/>}/>
                    <Route path="*" element={<Navigate to="/login" replace/>}/>
                </Routes>
            </Suspense>
        </BrowserRouter>
    </StrictMode>,
);