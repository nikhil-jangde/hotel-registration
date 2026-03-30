<template>
  <div class="h-screen w-full flex flex-col overflow-hidden bg-gray-50 dark:bg-gray-900">
    <Header v-if="!isAuthPage" />
    
    <main :class="['flex-1 flex overflow-hidden min-w-0', isAuthPage ? 'h-full w-full' : '']">
      <Sidebar v-if="!isAuthPage" />
      
      <div class="flex-1 overflow-auto p-6 bg-gray-50 dark:bg-gray-900">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Sidebar from './component/layout/Sidebar.vue';
import Header from './component/layout/Header.vue';

const route = useRoute();
const isAuthPage = computed(() => {
  return route.name === 'Login' || route.name === 'Signup' || route.path === '/login' || route.path === '/signup' || route.meta.guest === true;
});
</script>
