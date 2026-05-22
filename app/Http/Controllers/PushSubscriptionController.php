<?php

namespace App\Http\Controllers;

use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PushSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|string',
            'auth_key' => 'nullable|string',
            'p256dh_key' => 'nullable|string',
        ]);

        Auth::user()->pushSubscriptions()->updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'auth_key' => $request->auth_key,
                'p256dh_key' => $request->p256dh_key,
                'device_type' => $request->header('User-Agent'),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['endpoint' => 'required|string']);

        Auth::user()->pushSubscriptions()
            ->where('endpoint', $request->endpoint)
            ->delete();

        return response()->json(['success' => true]);
    }
}
