import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        purge({
            templates: ['blade']
        }),
    ],
    server: {
        host: true,
        port: 8443,
        strictPort: true,
        hmr: {
            protocol: 'wss',
            host: 'ping.test',
            port: 8443,
            strictPort: true,
            timeout: 1000,
        }
    }
});
