<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'identifier' => 'required|string',
            'details' => 'nullable|array',
        ]);

        $data['provider_id'] = $request->user()->provider->id;

        $service = Service::create($data);
        return response()->json(['service' => $service], 201);
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);
        $service->update($request->only(['name', 'identifier', 'details']));
        return response()->json(['service' => $service]);
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
