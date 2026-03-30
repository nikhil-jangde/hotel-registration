<template>
  <div class="flex flex-col h-full">
    <div class="flex-1 space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 border-b pb-4">Location</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Country -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Country *</label>
          <input 
            v-model="hotelStore.formData.country" 
            type="text" 
            placeholder="e.g. USA"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.country" class="text-red-500 text-xs">{{ errors.country }}</p>
        </div>

        <!-- City -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">City *</label>
          <input 
            v-model="hotelStore.formData.city" 
            type="text" 
            placeholder="e.g. New York"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.city" class="text-red-500 text-xs">{{ errors.city }}</p>
        </div>

        <!-- Address -->
        <div class="space-y-2 md:col-span-2">
          <label class="text-sm font-semibold text-gray-700">Physical Address *</label>
          <input 
            v-model="hotelStore.formData.address" 
            type="text" 
            placeholder="123 Luxury Avenue, Suit 400"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.address" class="text-red-500 text-xs">{{ errors.address }}</p>
        </div>

        <!-- Postal Code -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Postal / Zip Code</label>
          <input 
            v-model="hotelStore.formData.postalCode" 
            type="text" 
            placeholder="e.g. 10001"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.postalCode" class="text-red-500 text-xs">{{ errors.postalCode }}</p>
        </div>
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
        @click="next"
        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-semibold transition shadow-md flex items-center"
      >
        Next Step
        <PhArrowRight :size="18" class="ml-2" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useHotelRegistrationStore } from '../../stores/hotelRegistration';
import { hotelBaseSchema } from '../../schemas/hotel';
import { PhArrowRight, PhArrowLeft } from '@phosphor-icons/vue';

const router = useRouter();
const hotelStore = useHotelRegistrationStore();
const errors = ref({});

const validate = () => {
    errors.value = {};
    const stepSchema = hotelBaseSchema.pick({
        country: true,
        city: true,
        address: true,
        postalCode: true
    });    
    
    const result = stepSchema.safeParse(hotelStore.formData);
    if (!result.success) {
        result.error.issues.forEach(issue => {
            errors.value[issue.path[0]] = issue.message;
        });
        return false;
    }
    return true;
};

const next = () => {
    if (validate()) {
        router.push('/register/details');
    }
};

const back = () => {
    router.push('/register/description');
};
</script>
