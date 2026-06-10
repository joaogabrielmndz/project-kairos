// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  modules: [
    '@nuxt/eslint',
    '@nuxt/ui',
    '@nuxt/image',
    '@nuxtjs/google-fonts',
  ],

  devtools: {
    enabled: true
  },

  css: ['~/assets/css/main.css'],

  googleFonts: {
    download: true,
    inject: true,
    families: {
      'Roboto+Mono': [400, 600, 800]
    }
  },

  routeRules: {
    '/': { prerender: true }
  },

  compatibilityDate: '2025-01-15',

  eslint: {
    config: {
      stylistic: {
        commaDangle: 'never',
        braceStyle: '1tbs'
      }
    }
  }
})