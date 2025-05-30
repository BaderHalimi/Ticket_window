/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        primary: '#2D9CDB',
        secondary: '#27AE60',
        accent: '#F2994A',
        background: '#F9FAFB',
        card: '#FFFFFF',
        textdark: '#2C3E50',
        textlight: '#7F8C8D',
        error: '#EB5757'
      },
      borderRadius: {
        'none': '0px',
        'sm': '4px',
        DEFAULT: '8px',
        'md': '12px',
        'lg': '16px',
        'xl': '20px',
        '2xl': '24px',
        '3xl': '32px',
        'full': '9999px',
        'button': '8px'
      }
    },
  },
  plugins: [],
}

