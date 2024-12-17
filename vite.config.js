import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    // server: {
    //     host: '192.168.1.102', // Cho phép chạy trên mọi địa chỉ IP của máy
    //     port: 4000,      // Cổng có thể được chỉnh sửa theo nhu cầu
    // },
    plugins: [
        laravel({
            input: 'resources/js/app.jsx',
            refresh: true,
        }),
        react(),
    ],
});
