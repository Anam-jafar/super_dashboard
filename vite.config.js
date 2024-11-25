import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
    ]),
  ],
  server: {
    host: '0.0.0.0', // Allow Vite to listen on all interfaces
    port: 5173,      // Default Vite port
    hmr: {
      host: '192.168.56.10', // Replace with your machine's IP
    },
    cors: true, // Allow CORS for cross-origin requests
  },
});
