<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-sm border border-gray-100">
      <div>
        <div class="flex justify-center">
          <PhBuildings :size="48" weight="duotone" class="text-blue-600" />
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
      </div>
      <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" required v-model="form.email"
              class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
              placeholder="Email address" />
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <div class="relative">
              <input id="password" name="password" :type="!passwordVisible ? 'password' : 'text'" autocomplete="current-password" required
                v-model="form.password"
                class="appearance-none rounded-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                placeholder="Password" />
              <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer"
                @click.stop="passwordVisible = !passwordVisible">
                <PhEye v-if="passwordVisible" class="text-gray-800 hover:text-gray-600" :size="20" />
                <PhEyeSlash v-else="!passwordVisible" class="text-gray-800 hover:text-gray-600" :size="20" />
              </div>
            </div>
          </div>
        </div>

        <div v-if="error" class="text-red-500 text-sm text-center">
          {{ error }}
        </div>

        <div>
          <button type="submit" :disabled="loading"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 transition-colors">
            {{ loading ? 'Signing in...' : 'Sign in' }}
          </button>
        </div>

        <div class="text-center">
          <router-link to="/signup" class="text-sm font-medium text-blue-600 hover:text-blue-500">
            Don't have an account? Sign up
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '../../stores/user';
import { PhBuildings, PhEye, PhEyeSlash } from '@phosphor-icons/vue';

const router = useRouter();
const userStore = useUserStore();

const form = reactive({
  email: '',
  password: ''
});

const loading = ref(false);
const error = ref('');
const passwordVisible = ref(false);

const handleLogin = async () => {
  loading.value = true;
  error.value = '';
  try {
    await userStore.login(form);
    router.push('/');
  } catch (e) {
    error.value = 'Invalid credentials. Please try again.';
  } finally {
    loading.value = false;
  }
};
</script>
