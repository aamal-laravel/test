<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function preferences()
    {
        return response()->json(['preferences' => Preference::all()]);
    }

    public function updatePreference(Request $request, Preference $preference)
    {
        $preference->update($request->only(['name', 'type']));
        return response()->json(['preference' => $preference]);
    }

    public function pendingBookings()
    {
        // show bookings that are not accepted/canceled? migrations default accepted
        $items = Booking::where('status', 'accepted')->get();
        return response()->json(['pending' => $items]);
    }

    public function stats()
    {
        return response()->json([
            'tourists' => \App\Models\Tourist::count(),
            'providers' => \App\Models\Provider::count(),
            'bookings' => \App\Models\Booking::count(),
        ]);
    }
}
