<template>
  <div class="max-w-4xl mx-auto py-8">
    <!-- Stepper indicator -->
    <div class="mb-12">
      <div class="grid grid-cols-5">
        <div v-for="step in 5" :key="step" class="relative flex flex-col items-center">
          <div :class="[
            'w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300',
            currentStep >= step ? 'bg-blue-600 border-blue-600 text-white shadow-md' : 'bg-white border-gray-300 text-gray-500'
          ]">
            <PhCheck v-if="currentStep > step" :size="20" weight="bold" />
            <span v-else>{{ step }}</span>
          </div>
          <span class="mt-2 text-xs font-medium text-gray-500 hidden sm:block">
            {{ stepLabels[step - 1] }}
          </span>
          <div v-if="step !== 5" class="absolute -right-5 top-1/2 h-px w-10 bg-gray-400"></div>
        </div>
      </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 min-h-[500px] flex flex-col">
      <router-view v-slot="{ Component }">
        <transition name="fade-slide" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { PhCheck } from '@phosphor-icons/vue';
import { useHotelRegistrationStore } from '../../stores/hotelRegistration';
import router from '../../router';
const { currentStep: currentStepStore } = useHotelRegistrationStore();

onMounted(() => {
  if (currentStepStore === 1) {
    router.push('/register/description');
  }
})

const route = useRoute();
const stepLabels = ['Basic Info', 'Location', 'Details', 'Policies', 'Account'];

const currentStep = computed(() => {
  if (route.path.includes('/register/description')) return 1;
  if (route.path.includes('/register/location')) return 2;
  if (route.path.includes('/register/details')) return 3;
  if (route.path.includes('/register/policies')) return 4;
  if (route.path.includes('/register/account')) return 5;
  return 1;
});
</script>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: all 0.3s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateX(20px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
