<template>
    <aside
        class="w-[80px] h-full bg-gray-500 dark:bg-gray-800 flex flex-col items-center py-6 shrink-0 shadow-lg z-10 transition-all duration-300">
        <div class="flex flex-col gap-6 mt-2">
            <router-link to="/" 
                v-tooltip="{ content: 'All Hotels', placement: 'right' }"
                :class="[
                    'h-7 w-7 rounded-md flex items-center justify-center border transition focus:outline-none cursor-pointer',
                    isActive('/')
                        ? 'bg-blue-400 dark:bg-blue-500 text-gray-800 dark:text-gray-200 border-white dark:border-gray-300 shadow-md'
                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600'
                ]">
                <PhCity :size="16" />
            </router-link>

            <router-link to="/register" 
                v-tooltip="{ content: 'Add new hotel', placement: 'right' }"
                :class="[
                    'h-7 w-7 rounded-md flex items-center justify-center border transition focus:outline-none cursor-pointer',
                    isActive('/register')
                        ? 'bg-blue-500 dark:bg-blue-600 text-gray-800 dark:text-gray-200 border-white dark:border-gray-300 shadow-md'
                        : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 border-gray-200 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600'
                ]">
                <PhMapPinPlus :size="16" />
            </router-link>
        </div>
    </aside>
</template>

<script setup>
import { useRoute } from 'vue-router';
import { PhCity, PhMapPinPlus } from '@phosphor-icons/vue';

const route = useRoute();

const isActive = (path) => {
    if (path === '/') {
        return route.path === '/';
    }

    return route.path.startsWith(path);
};
</script>
