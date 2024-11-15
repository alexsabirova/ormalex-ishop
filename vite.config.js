import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    css: {
        preprocessorOptions: {
            scss: {
                silenceDeprecations: ['legacy-js-api'],
            },
        },
    },
    server: {
      host: '0.0.0.0',
      hmr: {
          clientPort: 5173,
          host: 'localhost',
          protocol: 'ws'
      },
      port: 5173,
      watch: {
          usePolling: true,
      },

    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/main.sass',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
