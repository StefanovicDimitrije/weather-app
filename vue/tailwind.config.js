const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
      "./index.html",
      "./src/**/*.{vue,js,ts,jsx,tsx}"
  ],
  theme: {
    extend: {
        spacing: {
            '128': '32rem',
        }
    },
  },
  plugins: [
      plugin(function ({ addUtilities }) {
          addUtilities({
                  '.scrollbar-hide': {
                      /* IE and Edge */
                      '-ms-overflow-style': 'none',

                      /* Firefox */
                      'scrollbar-width': 'none',

                      /* Safari and Chrome */
                      '&::-webkit-scrollbar': {
                          display: 'none'
                      }
                  }
              }
          )
      })
  ],
}
