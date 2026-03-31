<?php

namespace Tests\Feature;

use App\Jobs\SendHotelRegistrationEmailJob;
use App\Models\User;
use App\Models\Hotel;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class HotelRegistrationTest extends TestCase
{
    public function test_hotel_registration_sends_email_to_mailtrap(): void
    {
        
        // Mock a user for authentication
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $hotelData = [
            'name' => 'Grand Palace Hotel',
            'email' => 'nikhiljangde123@gmail.com',
            'city' => 'New York',
            'address' => '123 Luxury Ave',
            'phone' => '1234567890'
        ];

        $response = $this->postJson('/api/hotels', $hotelData);

        $response->assertStatus(201);
        
        $hotel = Hotel::where('name', 'Grand Palace Hotel')->first();
        $this->assertNotNull($hotel);
    }
}
