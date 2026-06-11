import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                    'resources/js/app.js',
                    'resources/css/beranda.css',
                     'resources/css/kelurahan.css',
                     'resources/css/statistik.css',
                     'resources/css/topbar.css',
                     'resources/css/datawarga.css',
                     'resources/css/profil.css',
                    ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
