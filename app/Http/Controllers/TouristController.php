<?php

namespace App\Http\Controllers;

use App\Models\Tourist;
use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;

class TouristController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $tourist = $user->tourist;

        return response()->json(['tourist' => $tourist]);
    }

    public function updatePreferences(Request $request)
    {
        $user = $request->user();
        $tourist = $user->tourist;

        $prefs = $request->input('preferences', []);
        // Expect array of preference ids with optional pivot type
        $tourist->preferences()->sync($prefs);

        return response()->json(['message' => 'Preferences updated']);
    }

    public function bookings(Request $request)
    {
        $user = $request->user();
        $tourist = $user->tourist;

        $items = Booking::where('tourist_id', $tourist->id)->with('service')->get();
        return response()->json(['bookings' => $items]);
    }

    public function notifications(Request $request)
    {
        $user = $request->user();
        $tourist = $user->tourist;

        $notes = $tourist->notifications()->get();
        return response()->json(['notifications' => $notes]);
    }
}
