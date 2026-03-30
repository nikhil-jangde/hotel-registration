<template>
  <div class="flex flex-col h-full">
    <div class="flex-1 space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 border-b pb-4">Finalize Account</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Username -->
        <div class="space-y-2 md:col-span-2">
          <label class="text-sm font-semibold text-gray-700">Display Username *</label>
          <input 
            v-model="hotelStore.formData.username" 
            type="text" 
            placeholder="e.g. jdoe_inn"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.username" class="text-red-500 text-xs">{{ errors.username }}</p>
        </div>

        <!-- Password -->
        <div class="relative space-y-2">
          <label class="text-sm font-semibold text-gray-700">Dashboard Password *</label>
          <input 
            v-model="hotelStore.formData.password" 
            :type="showPassword ? 'text' : 'password'" 
            placeholder="••••••••"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.password" class="text-red-500 text-xs">{{ errors.password }}</p>
        </div>

        <!-- Confirm Password -->
        <div class="relative space-y-2">
          <label class="text-sm font-semibold text-gray-700">Confirm Password *</label>
          <input 
            v-model="hotelStore.formData.confirmPassword" 
            :type="showPassword ? 'text' : 'password'" 
            placeholder="••••••••"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.confirmPassword" class="text-red-500 text-xs">{{ errors.confirmPassword }}</p>
        </div>
      </div>

      <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 mt-4">
          <p class="text-xs text-blue-800 leading-relaxed font-medium">
             By clicking "Finish", you agree that all information provided is accurate and representative of the hotel facility.
          </p>
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-10 pt-6 border-t flex justify-between">
      <button 
        @click="back"
        class="text-gray-600 hover:text-gray-900 px-6 py-2.5 font-semibold transition flex items-center"
      >
        <PhArrowLeft :size="18" class="mr-2" />
        Back
      </button>
      <button 
        @click="finish"
        :disabled="loading"
        class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white px-10 py-2.5 rounded-xl font-bold transition shadow-md flex items-center"
      >
        {{ loading ? 'Saving...' : 'Finish & Register' }}
        <PhCloudArrowUp v-if="!loading" :size="20" class="ml-2" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useHotelRegistrationStore } from '../../stores/hotelRegistration';
import { hotelRegistrationSchema, hotelBaseSchema } from '../../schemas/hotel';
import { PhArrowLeft, PhCloudArrowUp } from '@phosphor-icons/vue';

const router = useRouter();
const hotelStore = useHotelRegistrationStore();
const errors = ref({});
const loading = ref(false);
const showPassword = ref(true);

const finish = async () => {
    errors.value = {};
    const result = hotelRegistrationSchema.safeParse(hotelStore.formData);
    
    if (!result.success) {
        result.error.issues.forEach(issue => {
            // If the error is on field from a previous step, we show a general error
            errors.value[issue.path[0]] = issue.message;
        });
        return;
    }

    loading.value = true;
    try {
        await axios.post('/api/hotels', hotelStore.formData);
        hotelStore.resetForm();
        router.push('/');
    } catch (e) {
        alert('Failed to register hotel. Please try again.');
    } finally {
        loading.value = false;
    }
};

const back = () => {
    router.push('/register/policies');
};
</script>
