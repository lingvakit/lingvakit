import {defineConfig, loadEnv} from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");

    const hmrHost = env.VITE_HMR_HOST;
    const hmrProtocol = env.VITE_HMR_PROTOCOL;
    const hmrPort = env.VITE_HMR_PORT ? Number(env.VITE_HMR_PORT) : undefined;

    return {
        plugins: [
            laravel({
                input: [
                    "resources/js/admin/app/app.tsx",
                    "resources/js/public/auth/app.tsx",
                ],
                refresh: true,
            }),
            react(),
        ],

        server: {
            host: "0.0.0.0",
            port: 5173,
            strictPort: true,
            hmr: {
                host: hmrHost,
                protocol: hmrProtocol,
                clientPort: hmrPort,
                path: "/vite-hmr",
            },
        },

        build: {
            outDir: "public/build",
            emptyOutDir: true,
        },
    };
});