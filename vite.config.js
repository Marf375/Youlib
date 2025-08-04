import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    
    plugins: [
        laravel({
            input: ['resources/views/logo.png','resources/js/app.jsx','resources/js/app.js','resources/js/book.jsx','resources/js/bootstrap.js','resources/js/login.js','resources/js/navig.jsx','resources/js/vkladki.jsx','resources/js/vkladki1.jsx','resources/js/components/adb.jsx','resources/js/components/card.jsx','resources/js/components/card_a.jsx','resources/js/components/cart.jsx','resources/js/components/inma.jsx','resources/js/components/love.jsx','resources/js/components/news.jsx','resources/js/components/reviews.jsx','resources/js/components/reviews_noa.jsx','resources/js/Pages/Home.jsx','resources/css/style.css','resources/css/sss.css','resources/css/stars.css','resources/css/profile.css','resources/css/reviewsstyle.css','resources/css/reg.css','resources/css/header.css','resources/css/adbs.css','resources/css/app.css','resources/css/login.css'],
            refresh: true,
        }),
        react(),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
    },
});
