<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        // list all notifications (admin) or user's notifications
        if ($request->user()->is_admin ?? false) {
            return response()->json(['notifications' => Notification::all()]);
        }

        $tourist = $request->user()->tourist;
        return response()->json(['notifications' => $tourist ? $tourist->notifications()->get() : []]);
    }

    public function createForTourist(Request $request)
    {
        $data = $request->validate(['text' => 'required|string']);
        $note = Notification::create(['text' => $data['text']]);

        // optionally attach to tourist ids
        if ($request->filled('tourist_ids')) {
            $note->tourists()->attach($request->input('tourist_ids'));
        }

        return response()->json(['notification' => $note], 201);
    }
}
