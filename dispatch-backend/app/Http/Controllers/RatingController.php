<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rider_id' => 'nullable|exists:users,id',
            'rated_user_id' => 'nullable|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();

        $rating = Rating::create($validated);

        return response()->json(['message' => 'Rating submitted successfully!', 'data' => $rating], 201);
    }

    public function show($id)
    {
        $ratings = Rating::where('rider_id', $id)
            ->orWhere('rated_user_id', $id)
            ->get();

        $average = $ratings->avg('rating');

        return response()->json(['ratings' => $ratings, 'average' => $average]);
    }
}
