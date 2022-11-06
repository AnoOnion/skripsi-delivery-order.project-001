module.exports = {
    darkMode: 'class',

    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', 'Segoe UI', 'arial'],
            },

            fontSize: {
                '2xs': ['.65rem', {
                    lineHeight: '.75rem',
                }],
            },

            backgroundImage: {
                'radial-gradient-l': 'radial-gradient(circle at top left, transparent 0.5rem, #ffffff 0.5rem)',
                'radial-gradient-dark-l': 'radial-gradient(circle at top left, transparent 0.5rem, #1e293b 0.5rem)'
            }
        },
    }
};
