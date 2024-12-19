import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        
        "resources/js/app.jsx",
        "resources/css/filament/admin/theme.css",
      
        'resources/css/app.css', 'resources/js/app.jsx',
      ],
      refresh: true,
    }),
    react({
      include: /\.(js|jsx|ts|tsx)$/, // Ensure .js and .jsx are included
    }),
  ],
  resolve: {
    extensions: ['.js', '.jsx'],
  },
  optimizeDeps: {
    esbuildOptions: {
      loader: {
        '.js': 'jsx', // Treat .js files as .jsx
      },
    },
  },
});






