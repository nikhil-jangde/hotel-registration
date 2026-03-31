<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return Hotel::with('user:id,name')->get();
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->all();
        $data['created_by_id'] = $user->_id;

        unset($data['confirmPassword']);

        $hotel = Hotel::create($data);

        return response()->json($hotel, 201);
    }
}
