<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'quantity' => 'integer|min:1',
            'price' => 'required|numeric',
        ]);

        $tourist = $request->user()->tourist;
        $data['tourist_id'] = $tourist->id;

        $booking = Booking::create($data);

        return response()->json(['booking' => $booking], 201);
    }

    public function myBookings(Request $request)
    {
        $tourist = $request->user()->tourist;
        return response()->json(['bookings' => Booking::where('tourist_id', $tourist->id)->get()]);
    }
}
