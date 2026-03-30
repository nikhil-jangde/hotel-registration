import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../stores/user';

const routes = [
    {
        path: '/',
        name: 'Dashboard',
        component: () => import('../pages/Dashboard.vue'),
        meta: { requiresAuth: true }
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('../component/auth/Login.vue'),
        meta: { guest: true }
    },
    {
        path: '/signup',
        name: 'Signup',
        component: () => import('../component/auth/Signup.vue'),
        meta: { guest: true }
    },
    {
        path: '/register',
        component: () => import('../pages/register/RegisterLayout.vue'),
        meta: { requiresAuth: true },
        children: [
            { path: '', redirect: '/register/description' },
            { path: 'description', name: 'RegStep1', component: () => import('../pages/register/StepDescription.vue') },
            { path: 'location', name: 'RegStep2', component: () => import('../pages/register/StepLocation.vue') },
            { path: 'details', name: 'RegStep3', component: () => import('../pages/register/StepDetails.vue') },
            { path: 'policies', name: 'RegStep4', component: () => import('../pages/register/StepPolicies.vue') },
            { path: 'account', name: 'RegStep5', component: () => import('../pages/register/StepAccount.vue') },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const userStore = useUserStore();

    // Ensure we have user data if authenticated
    if (userStore.isAuthenticated === false && userStore.user === null) {
        await userStore.fetchUser();
    }

    if (to.meta.requiresAuth && !userStore.isAuthenticated) {
        next('/login');
    } else if (to.meta.guest && userStore.isAuthenticated) {
        next('/');
    } else {
        next();
    }
});

export default router;
