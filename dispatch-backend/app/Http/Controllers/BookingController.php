<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
        ]);

        $booking = Booking::create([
            'user_id' => $request->user()->id, // assuming the user is logged in
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'status' => 'pending',
        ]);

        return response()->json($booking, 201);
    }

    public function accept(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->rider_id = $request->rider_id;
        $booking->status = 'accepted';
        $booking->save();

        return response()->json(['message' => 'Booking accepted']);
    }

    public function complete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'completed';
        $booking->save();

        return response()->json(['message' => 'Booking completed']);
    }
}
