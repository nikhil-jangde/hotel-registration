<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\User;
use App\Jobs\SendHotelRegistrationEmail;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class HotelMailTest extends TestCase
{
    /**
     * Test that an email job is dispatched when a hotel is registered.
     */
    public function test_email_job_is_dispatched_after_hotel_registration(): void
    {
        Bus::fake();

        // Ensure MongoDB doesn't use ':memory:' from phpunit.xml
        config(['database.connections.mongodb.database' => 'testing_db']);

        // Create a user for authentication if needed (though store method handles it)
        $user = new User(['_id' => '67e8c8a1b2c3d4e5f607a8b9', 'name' => 'Test User']);
        $this->actingAs($user);

        $hotelData = [
            'name' => 'Luxury Palace',
            'email' => 'nikhiljangde123@gmail.com',
            'phone' => '1234567890',
            'city' => 'New York',
            'country' => 'USA',
        ];

        $response = $this->postJson('/api/hotels', $hotelData);

        $response->assertStatus(201);
        
        // Assert that the job was dispatched
        Bus::assertDispatched(SendHotelRegistrationEmail::class, function ($job) use ($hotelData) {
            return $job->hotel['email'] === $hotelData['email'];
        });
    }
}
