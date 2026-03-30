<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Hotel extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'hotels';

    protected $fillable = [
        'name', 'description', 'email', 'phone', 'hobby', 'sport', 'website',
        'country', 'city', 'address', 'postalCode',
        'starRating', 'totalRooms', 'checkInTime', 'checkOutTime',
        'amenities', 'cancellationPolicy', 'username', 'password', 'created_by_id'
    ];

    public function user()
    {
        // For MongoDB relationships, we can store user details directly or use embed/relation
        return $this->belongsTo(User::class , 'created_by_id');
    }
}
