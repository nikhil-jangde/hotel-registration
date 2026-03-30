<template>
  <div class="flex flex-col h-full">
    <div class="flex-1 space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 border-b pb-4">Hotel Details</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Star Rating -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Star Rating (1-5) *</label>
          <input 
            v-model.number="hotelStore.formData.starRating" 
            type="number" min="1" max="5"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.starRating" class="text-red-500 text-xs">{{ errors.starRating }}</p>
        </div>

        <!-- Total Rooms -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Total Rooms *</label>
          <input 
            v-model.number="hotelStore.formData.totalRooms" 
            type="number" min="1"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.totalRooms" class="text-red-500 text-xs">{{ errors.totalRooms }}</p>
        </div>

        <!-- Check-in Time -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Check-in Time (HH:MM) *</label>
          <input 
            v-model="hotelStore.formData.checkInTime" 
            type="text" placeholder="14:00"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.checkInTime" class="text-red-500 text-xs">{{ errors.checkInTime }}</p>
        </div>

        <!-- Check-out Time -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Check-out Time (HH:MM) *</label>
          <input 
            v-model="hotelStore.formData.checkOutTime" 
            type="text" placeholder="11:00"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
          />
          <p v-if="errors.checkOutTime" class="text-red-500 text-xs">{{ errors.checkOutTime }}</p>
        </div>
      </div>

      <!-- Amenities -->
      <div class="space-y-3">
        <label class="text-sm font-semibold text-gray-700">Amenities *</label>
        <div class="flex flex-wrap gap-3">
          <button 
            v-for="amenity in availableAmenities" 
            :key="amenity"
            @click="toggleAmenity(amenity)"
            type="button"
            :class="[
                'px-4 py-2 rounded-full border text-sm transition',
                hotelStore.formData.amenities.includes(amenity)
                ? 'bg-blue-600 border-blue-600 text-white'
                : 'bg-white border-gray-200 text-gray-600 hover:border-blue-400'
            ]"
          >
            {{ amenity }}
          </button>
        </div>
        <p v-if="errors.amenities" class="text-red-500 text-xs">{{ errors.amenities }}</p>
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

const availableAmenities = ['Wi-Fi', 'Pool', 'Spa', 'Gym', 'Restaurant', 'Parking', 'Room Service', 'Bar'];

const toggleAmenity = (amenity) => {
    const index = hotelStore.formData.amenities.indexOf(amenity);
    if (index === -1) {
        hotelStore.formData.amenities.push(amenity);
    } else {
        hotelStore.formData.amenities.splice(index, 1);
    }
};

const validate = () => {
    errors.value = {};
    const stepSchema = hotelBaseSchema.pick({
        starRating: true,
        totalRooms: true,
        checkInTime: true,
        checkOutTime: true,
        amenities: true
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
        router.push('/register/policies');
    }
};

const back = () => {
    router.push('/register/location');
};
</script>
