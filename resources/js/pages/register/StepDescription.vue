<template>
  <div class="flex flex-col h-full">
    <div class="flex-1 space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 border-b pb-4">Basic Information</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Hotel Name -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Hotel Name *</label>
          <input v-model="hotelStore.formData.name" type="text" placeholder="e.g. Grand Palace Hotel"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.name" class="text-red-500 text-xs">{{ errors.name }}</p>
        </div>

        <!-- Contact Email -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Contact Email *</label>
          <input v-model="hotelStore.formData.email" type="email" placeholder="contact@hotel.com"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.email" class="text-red-500 text-xs">{{ errors.email }}</p>
        </div>

        <!-- Phone -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Phone Number *</label>
          <input v-model="hotelStore.formData.phone" type="text" placeholder="+1 (555) 000-0000"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.phone" class="text-red-500 text-xs">{{ errors.phone }}</p>
        </div>

        <!-- Website -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Website URL</label>
          <input v-model="hotelStore.formData.website" type="text" placeholder="https://www.example.com"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.website" class="text-red-500 text-xs">{{ errors.website }}</p>
        </div>

        <!-- Hobby -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Hobby *</label>
          <input v-model="hotelStore.formData.hobby" type="text"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.hobby" class="text-red-500 text-xs">{{ errors.hobby }}</p>
        </div>

        <!-- Sport -->
        <div class="space-y-2">
          <label class="text-sm font-semibold text-gray-700">Sport *</label>
          <input v-model="hotelStore.formData.sport" type="text"
            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" />
          <p v-if="errors.sport" class="text-red-500 text-xs">{{ errors.sport }}</p>
        </div>
      </div>

      <!-- Description -->
      <div class="space-y-2">
        <label class="text-sm font-semibold text-gray-700">Description *</label>
        <textarea v-model="hotelStore.formData.description" rows="4"
          placeholder="Describe your hotel's unique features, history, and atmosphere..."
          class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"></textarea>
        <p v-if="errors.description" class="text-red-500 text-xs">{{ errors.description }}</p>
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-10 pt-6 border-t flex justify-end">
      <button @click="next"
        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-xl font-semibold transition shadow-md flex items-center">
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
import { PhArrowRight } from '@phosphor-icons/vue';

const router = useRouter();
const hotelStore = useHotelRegistrationStore();
const errors = ref({});

const validate = () => {
  errors.value = {};
  const stepSchema = hotelBaseSchema.pick({
    name: true,
    email: true,
    phone: true,
    website: true,
    description: true,
    hobby: true,
    sport: true
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
    router.push('/register/location');
  }
};
</script>
