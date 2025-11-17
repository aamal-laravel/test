<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Service;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function profile(Request $request)
    {
        $provider = $request->user()->provider;
        return response()->json(['provider' => $provider]);
    }

    public function updateInfo(Request $request)
    {
        $provider = $request->user()->provider;
        $provider->update($request->only(['name', 'description']));
        return response()->json(['provider' => $provider]);
    }

    public function services(Request $request)
    {
        $provider = $request->user()->provider;
        return response()->json(['services' => $provider->services()->get()]);
    }

    public function comments(Request $request)
    {
        $provider = $request->user()->provider;
        return response()->json(['comments' => $provider->comments()->with('tourist')->get()]);
    }

    public function ratings(Request $request)
    {
        $provider = $request->user()->provider;
        return response()->json(['ratings' => $provider->ratings()->with('tourist')->get()]);
    }
}
