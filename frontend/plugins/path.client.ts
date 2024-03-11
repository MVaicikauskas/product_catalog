export default defineNuxtPlugin({
    order: -25,
    setup (nuxtApp) {
        delete nuxtApp.payload.path
    }
})