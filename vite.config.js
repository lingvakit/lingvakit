import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: true,
        port: 5173,
        strictPort: true,
        hmr: {
            host: "localhost",
            protocol: "ws",
            port: 5173,
        },
        cors: true,
    },
    plugins: [
        laravel({
            input: ["resources/js/admin/main.jsx"],
            refresh: true,
        }),
    ],
});