// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt'
  ],
  app: {
    head: {
      link: [
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css?family=Open+Sans:300,400|Source+Code+Pro:700,900&display=swap' },
        { rel: 'stylesheet', href: 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' },
        { rel: 'stylesheet', href: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css' },
        { rel: 'stylesheet', href: '/assets/lib/slick/slick.css' },
        { rel: 'stylesheet', href: '/assets/lib/slick/slick-theme.css' },
        { rel: 'stylesheet', href: '/assets/css/style.css' },
      ],
      script: [
        {
          src: 'https://code.jquery.com/jquery-3.4.1.min.js',
          defer: true
        },
        {
          src: 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
          defer: true
        },
        {
          src: '/assets/lib/easing/easing.min.js',
          defer: true
        },
        {
          src: '/assets/lib/slick/slick.min.js',
          defer: true
        },
        {
          src: '/assets/lib/slick/slick.min.js',
          defer: true
        },
        {
          src: '/assets/js/main.js',
          defer: true
        }
      ],
    }
  }
})
