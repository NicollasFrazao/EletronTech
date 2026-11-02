// ESLint for the JavaScript of the project (resources/js and the tool configs). Any finding fails
// (`--max-warnings 0`), and the Sonar rules run at error level, as in the PHP gate.
import js from '@eslint/js';
import sonarjs from 'eslint-plugin-sonarjs';
import globals from 'globals';

const MAX_COGNITIVE_COMPLEXITY = 15;
const MAX_NESTING_DEPTH = 3;
const MAX_PARAMETERS = 4;

export default [
    {
        ignores: ['bootstrap/cache/', 'coverage/', 'node_modules/', 'public/build/', 'storage/', 'vendor/'],
    },
    js.configs.recommended,
    sonarjs.configs.recommended,
    {
        languageOptions: {
            globals: globals.node,
        },
        rules: {
            'sonarjs/cognitive-complexity': ['error', MAX_COGNITIVE_COMPLEXITY],
            'sonarjs/no-commented-code': 'error',
            'max-depth': ['error', MAX_NESTING_DEPTH],
            'max-params': ['error', MAX_PARAMETERS],
            curly: ['error', 'all'],
            eqeqeq: ['error', 'always'],
        },
    },
    {
        files: ['resources/js/**/*.js'],
        languageOptions: {
            globals: globals.browser,
        },
    },
];
