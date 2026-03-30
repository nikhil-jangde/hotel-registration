<template>
    <header class="h-[80px] w-full flex items-center justify-between px-6 bg-white dark:bg-gray-800 shadow-sm shrink-0">
        <div class="flex items-center text-blue-600 dark:text-blue-400">
            <PhBuildings :size="32" weight="duotone" />
            <span class="ml-3 font-semibold text-xl text-gray-800 dark:text-gray-200 hidden sm:block">Hotel Admin</span>
        </div>

        <div class="flex items-center gap-3">
            <!-- Theme Toggle Button -->
            <button @click="themeStore.toggleTheme"
                v-tooltip="themeStore.isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                class="h-10 w-10 rounded-full bg-gray-50 dark:bg-gray-700 flex items-center justify-center border border-gray-200 dark:border-gray-600 transition focus:outline-none hover:bg-gray-100 dark:hover:bg-gray-600">
                <PhSun v-if="!themeStore.isDark" :size="24" weight="fill" class="text-yellow-500" />
                <PhMoon v-else :size="24" weight="fill" class="text-blue-400" />
            </button>

            <!-- User profile popover -->
            <Popover>
                <PopoverTrigger as-child>
                    <button
                        class="h-10 w-10 rounded-full bg-blue-50 dark:bg-blue-900 flex items-center justify-center border border-blue-100 dark:border-blue-800 transition focus:outline-none hover:bg-blue-100 dark:hover:bg-blue-800">
                        <PhUser :size="24" weight="fill" class="text-blue-600 dark:text-blue-400" />
                    </button>
                </PopoverTrigger>
                <template #content>
                    <PopoverContent class="w-80">
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <h4 class="font-medium leading-none dark:text-gray-100">
                                {{ userStore.user?.name || 'User' }}
                            </h4>
                            <p class="text-sm text-muted-foreground dark:text-gray-400">
                                {{ userStore.user?.email }}
                            </p>
                        </div>
                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                Member since {{ formatDate(userStore.user?.created_at) }}
                            </p>
                        </div>
                    </div>
                </PopoverContent>
                </template>
            </Popover>

            <!-- Logout Button with tooltip -->
            <button @click="handleLogout" v-tooltip="'Logout'"
                class="h-10 w-10 rounded-full bg-red-50 dark:bg-red-900 cursor-pointer flex items-center justify-center border border-red-100 dark:border-red-800 hover:bg-red-100 dark:hover:bg-red-800 text-red-600 dark:text-red-400 transition focus:outline-none">
                <PhSignOut :size="22" weight="bold" />
            </button>
        </div>
    </header>
</template>

<script setup>
import { PhBuildings, PhUser, PhSignOut, PhSun, PhMoon } from '@phosphor-icons/vue';
import { useUserStore } from '../../stores/user';
import { useThemeStore } from '../../stores/theme';
import { useRouter } from 'vue-router';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'

const userStore = useUserStore();
const themeStore = useThemeStore();
const router = useRouter();

const handleLogout = async () => {
    await userStore.logout();
    router.push('/login');
};

const formatDate = (dateString) => {
    if (!dateString) return 'Unknown';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>
