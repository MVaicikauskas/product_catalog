// https://nuxt.com/docs/api/configuration/nuxt-config
// @ts-ignore
export default defineNuxtConfig({
  devtools: { enabled: true },
  css: [
    'bootstrap/dist/css/bootstrap.css'
  ],
  routeRules: {
    'api/**': {
      cors: true,
      proxy: { to: "http://127.0.0.1:8000/api/**" }
    }
  },
  runtimeConfig: {
    secretKey: '',
    public: {
      apiBase: 'http://127.0.0.1:8000/api'
    }
  },
  modules: [
    '@pinia/nuxt',
  ],
})
