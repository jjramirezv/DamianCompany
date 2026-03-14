/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        damian: {
          dark: '#152036',        // Fondo principal oscuro
          darker: '#0f404f',      // Variación oscura
          card: '#182b49',        // Fondo de las tarjetas (cards)
          header: '#1a4e5c',      // Para encabezados o modales
          green: '#22a15e',       // Tu verde principal (botones CTA)
          green_light: '#3caa83', // Verde secundario/hover
          blue: '#1bb1e3',        // Azul/celeste de acento
          blue_light: '#31bae4',  // Celeste claro
          light: '#f3f3f3',       // Textos claros o fondos blancos
          gray_light: '#eaeceb',  // Grises para bordes o textos secundarios
          gray_mid: '#99a5b5',
          gray_dark: '#a5aebd',
        }
      }
    },
  },
  plugins: [],
}