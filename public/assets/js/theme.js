/*!
 * DaurixSkills Theme Toggler
 * Persists theme preference in localStorage
 */
(() => {
    'use strict'

    const getStoredTheme = () => localStorage.getItem('theme')
    const setStoredTheme = theme => localStorage.setItem('theme', theme)

    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme()
        if (storedTheme) {
            return storedTheme
        }
        // Fallback to system preference
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
    }

    const setTheme = theme => {
        if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.setAttribute('data-bs-theme', 'dark')
        } else {
            document.documentElement.setAttribute('data-bs-theme', theme)
        }
    }

    setTheme(getPreferredTheme())

    window.addEventListener('DOMContentLoaded', () => {
        const themeSwitcher = document.querySelector('#themeSwitch')

        if (themeSwitcher) {
            // Set the toggle state on load
            const currentTheme = getPreferredTheme();
            if (currentTheme === 'dark') {
                themeSwitcher.checked = true;
            }

            themeSwitcher.addEventListener('change', () => {
                const theme = themeSwitcher.checked ? 'dark' : 'light'
                setStoredTheme(theme)
                setTheme(theme)
            })
        }
    })
})()
