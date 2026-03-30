import { ref, computed } from 'vue';
import axios from 'axios';

const user = ref(null);
const isAuthenticated = computed(() => !!user.value);

export function useAuth() {
    const fetchUser = async () => {
        try {
            const response = await axios.get('/api/user');
            user.value = response.data;
        } catch (error) {
            user.value = null;
        }
    };

    const login = async (credentials) => {
        // Laravel Sanctum CSRF protection
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', credentials);
        await fetchUser();
        return response.data;
    };

    const logout = async () => {
        await axios.post('/logout');
        user.value = null;
        window.location.href = '/login';
    };

    return {
        user,
        isAuthenticated,
        fetchUser,
        login,
        logout
    };
}
