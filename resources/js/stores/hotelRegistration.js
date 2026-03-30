import { defineStore } from 'pinia';
import { reactive, ref } from 'vue';

export const useHotelRegistrationStore = defineStore('hotelRegistration', () => {
    const formData = reactive({
        name: '',
        description: '',
        email: '',
        phone: '',
        hobby: '',
        sport: '',
        website: '',
        country: '',
        city: '',
        address: '',
        postalCode: '',
        starRating: 1,
        totalRooms: 1,
        checkInTime: '14:00',
        checkOutTime: '11:00',
        amenities: [],
        cancellationPolicy: '',
        username: '',
        password: '',
        confirmPassword: ''
    });

    const currentStep = ref(1);

    function setStep(step) {
        currentStep.value = step;
    }

    function resetForm() {
        Object.assign(formData, {
            name: '',
            description: '',
            email: '',
            phone: '',
            hobby: '',
            sport: '',
            website: '',
            country: '',
            city: '',
            address: '',
            postalCode: '',
            starRating: 1,
            totalRooms: 1,
            checkInTime: '14:00',
            checkOutTime: '11:00',
            amenities: [],
            cancellationPolicy: '',
            username: '',
            password: '',
            confirmPassword: ''
        });
        currentStep.value = 1;
    }

    return {
        formData,
        currentStep,
        setStep,
        resetForm
    };
});
