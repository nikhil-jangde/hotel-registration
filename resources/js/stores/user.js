import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import axios from 'axios';

export const useUserStore = defineStore('meta', () => {
    const user = ref(null);
    const isAuthenticated = computed(() => !!user.value);

    const fetchUser = async () => {
        try {
            const response = await axios.get('/api/user');
            user.value = response.data;
        } catch {
            user.value = null;
        }
    };

    const login = async (credentials) => {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/login', credentials);
        await fetchUser();
    };

    const signup = async (data) => {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/signup', data);
    };

    const logout = async () => {
        await axios.post('/logout');
        user.value = null;
    };

    return {
        user,
        isAuthenticated,
        fetchUser,
        login,
        signup,
        logout,
    };
});
