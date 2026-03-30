import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

export const useThemeStore = defineStore('theme', () => {
    const isDark = ref(false);

    // Load theme from localStorage on init
    const initTheme = () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            isDark.value = savedTheme === 'dark';
        } else {
            // Check system preference
            isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        applyTheme();
    };

    const toggleTheme = () => {
        isDark.value = !isDark.value;
    };

    const applyTheme = () => {
        if (isDark.value) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    // Watch for changes and save to localStorage
    watch(isDark, (newValue) => {
        localStorage.setItem('theme', newValue ? 'dark' : 'light');
        applyTheme();
    });

    return {
        isDark,
        initTheme,
        toggleTheme,
    };
});