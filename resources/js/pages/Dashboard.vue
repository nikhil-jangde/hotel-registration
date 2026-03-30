<template>
  <div class="h-full">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Hotel Directory</h1>
        <p class="text-gray-500 mt-1">Discover and manage premium stays around the globe.</p>
      </div>
      
      <div v-if="loading" class="flex items-center text-blue-600 font-medium">
         <PhCircleNotch :size="20" class="animate-spin mr-2" />
         Loading...
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!loading && hotels.length === 0" class="flex flex-col items-center justify-center py-24 bg-white rounded-3xl border-2 border-dashed border-gray-100">
        <div class="p-6 bg-blue-50 rounded-full mb-6">
            <PhBuildings :size="64" weight="duotone" class="text-blue-400" />
        </div>
        <h3 class="text-xl font-bold text-gray-900">No hotels registered yet</h3>
        <p class="text-gray-500 mt-2 mb-8">Be the first to list a premium property on our dashboard.</p>
        <router-link to="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold transition shadow-md shadow-blue-100 scale-in">
             Add My Hotel
        </router-link>
    </div>

    <!-- Hotel Grid -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 pb-12">
      <div 
        v-for="hotel in hotels" 
        :key="hotel._id" 
        class="bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl hover:shadow-gray-200/50 transition-all duration-500 group flex flex-col"
      >
        <!-- Mock Hotel Image -->
        <div class="h-48 bg-gradient-to-br from-blue-100 to-indigo-100 relative overflow-hidden shrink-0">
           <img 
            :src="`https://picsum.photos/seed/${hotel._id}/400/300`" 
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90"
           />
           <div class="absolute top-4 right-4 flex gap-1" v-tooltip="`${hotel.starRating} Star Hotel`">
             <div 
              v-for="i in 5" :key="i"
              :class="['p-1 rounded-full', i <= (hotel.starRating || 0) ? 'text-yellow-400' : 'text-gray-300']"
            >
              <PhStar weight="fill" :size="14" />
            </div>
           </div>
           <!-- Benchmark Badge (Random mock for visual excellence) -->
           <div v-if="hotel.totalRooms > 50" class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-2.5 py-1 rounded-lg text-[10px] font-bold text-blue-600 uppercase tracking-widest shadow-sm">
               Premium Choice
           </div>
        </div>

        <div class="p-6 flex flex-col flex-1">
          <div class="flex-1">
            <h3 class="font-bold text-gray-900 text-lg line-clamp-1 group-hover:text-blue-600 transition-colors">
              {{ hotel.name }}
            </h3>
            <div class="flex items-center text-gray-400 text-xs mt-1.5 font-medium">
              <PhMapPin :size="14" class="mr-1" weight="fill" />
              {{ hotel.city }}, {{ hotel.country }}
            </div>
            <p class="text-gray-500 text-sm mt-4 line-clamp-2 leading-relaxed">
              {{ hotel.description }}
            </p>
          </div>

          <div class="mt-6 pt-6 border-t border-gray-50 flex items-center justify-between">
            <div class="flex items-center" v-tooltip="`Created by ${hotel.user?.name || 'Unknown'}`">
               <div class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-100">
                  {{ (hotel.user?.name || 'U').charAt(0) }}
               </div>
               <div class="ml-2.5">
                  <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Created By</p>
                  <p class="text-xs font-semibold text-gray-700">{{ hotel.user?.name || 'Unknown' }}</p>
               </div>
            </div>
            
            <div class="text-right" v-tooltip="`Total capacity: ${hotel.totalRooms} rooms`">
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Rooms</p>
                <p class="text-xs font-extrabold text-blue-600">{{ hotel.totalRooms }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { PhMapPin, PhStar, PhBuildings, PhCircleNotch } from '@phosphor-icons/vue';

const hotels = ref([]);
const loading = ref(true);

const fetchHotels = async () => {
  loading.value = true;
  try {
    const response = await axios.get('/api/hotels');
    hotels.value = response.data;
  } catch (e) {
    console.error('Failed to load hotels');
  } finally {
    loading.value = false;
  }
};

onMounted(fetchHotels);
</script>

<style scoped>
@keyframes scaleIn {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.scale-in {
  animation: scaleIn 0.3s ease-out;
}
</style>
