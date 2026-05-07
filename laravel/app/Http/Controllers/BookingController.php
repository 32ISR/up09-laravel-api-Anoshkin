<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->orderBy('starts_at')->get();

        return response()->json($bookings, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'room_name' => 'required|string|max:100',
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'required|date|after:starts_at',
            'note' => 'string|max:500|nullable',
        ]);

        $booking = $request->user()->bookings()->create($data);

        return response()->json($booking, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id === $request->user()->id)
            return response()->json($booking, 200);
        else
            return response()->json([
                "message" => "Это не ваша бронь",
            ],  403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'room_name' => 'sometimes|string|max:100',
            'starts_at' => 'sometimes|date|after:now',
            'ends_at' => 'sometimes|date|after:starts_at',
            'note' => 'string|max:500|nullable',
        ]);

        if ($booking->user_id === $request->user()->id) {
            $booking->update($data);
            return response()->json($booking, 200);
        } else
            return response()->json([
                "message" => "Это не ваша бронь",
            ],  403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Booking $booking)
    {
        if ($booking->user_id === $request->user()->id)
            return response()->json($booking->delete, 200);
        else
            return response()->json([
                "message" => "Это не ваша бронь",
            ],  403);
    }
}
