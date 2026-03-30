import './bootstrap';
import '../css/app.css';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import FloatingVue from 'floating-vue';
import 'floating-vue/dist/style.css';
import { useUserStore } from './stores/user';
import { useThemeStore } from './stores/theme';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.use(router);
app.use(FloatingVue, {
    themes: {
        'tooltip': {
            distance: 8,
            delay: { show: 150, hide: 0 },
        },
    }
});

const userStore = useUserStore();
const themeStore = useThemeStore();

// Initialize theme
themeStore.initTheme();

// Fetch current session before mounting
userStore.fetchUser().then(() => {
    app.mount('#app');
});
