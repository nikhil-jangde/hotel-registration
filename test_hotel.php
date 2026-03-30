<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Hotel;
use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;

try {
    // Test the controller method directly
    $controller = new HotelController();
    $request = new Request();
    $request->merge([
        'name' => 'Controller Test Hotel',
        'email' => 'controller@example.com',
        'phone' => '123-456-7890',
        'description' => 'A beautiful test hotel from controller',
        'country' => 'Test Country',
        'city' => 'Test City',
        'address' => '123 Test Street',
        'postalCode' => '12345',
        'starRating' => 5,
        'totalRooms' => 100,
        'checkInTime' => '14:00',
        'checkOutTime' => '12:00',
        'amenities' => ['WiFi', 'Pool', 'Gym'],
        'cancellationPolicy' => 'Free cancellation 24 hours before check-in',
        'username' => 'testuser2',
        'password' => 'password123',
    ]);

    // Simulate authenticated user
    $user = new stdClass();
    $user->_id = '507f1f77bcf86cd799439011';
    $request->setUserResolver(function () use ($user) {
        return $user;
    });

    $response = $controller->store($request);
    echo 'Controller response: ' . $response->getContent() . PHP_EOL;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
