import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'

export default defineConfig({
  resolve: {
    alias: {
      '@': '/public/',
      'vue': process.env.NODE_ENV == 'production' ? 'vue/dist/vue.min.js' : 'vue/dist/vue.js'
    },
  },
  server: {
    host: true,
    hmr: {
      host: 'localhost',
    },
  },
  plugins: [
    laravel({
      input: [
        'resources/assets/sass/app.scss',
        'resources/assets/js/cms/app.js',
        'resources/assets/js/app.js',
        'resources/assets/sass/website/app.scss',
        'resources/assets/js/front/app.js',
      ],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          includeAbsolute: false
        }
      }
    }),
  ],
})
