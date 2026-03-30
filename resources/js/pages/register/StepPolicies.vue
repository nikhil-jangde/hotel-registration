<template>
  <div class="flex flex-col h-full">
    <div class="flex-1 space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 border-b pb-4">Policies</h2>
      
      <div class="space-y-4">
        <label class="text-sm font-semibold text-gray-700 block">Cancellation Policy *</label>
        <textarea 
          v-model="hotelStore.formData.cancellationPolicy" 
          rows="6"
          placeholder="What is your cancellation policy? e.g. Free cancellation up to 48 hours before check-in."
          class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"
        ></textarea>
        <div class="flex justify-between items-center text-xs text-gray-400">
           <p v-if="errors.cancellationPolicy" class="text-red-500">{{ errors.cancellationPolicy }}</p>
           <span>At least 10 characters</span>
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
        cancellationPolicy: true
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
        router.push('/register/account');
    }
};

const back = () => {
    router.push('/register/details');
};
</script>
