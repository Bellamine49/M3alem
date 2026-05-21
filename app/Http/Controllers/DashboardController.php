<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $view = $request->query('view', $user->role === 'worker' ? 'worker' : 'client');

        $data = ['view' => $view];

        if ($view === 'worker' && $user->workerProfile) {
            $data['upcomingBookings'] = Booking::where('worker_profile_id', $user->workerProfile->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereDate('booking_date', '>=', now())
                ->with('client')
                ->orderBy('booking_date')
                ->get();

            $data['pastBookings'] = Booking::where('worker_profile_id', $user->workerProfile->id)
                ->whereDate('booking_date', '<', now())
                ->orWhere('status', 'cancelled')
                ->with('client')
                ->orderByDesc('booking_date')
                ->limit(5)
                ->get();

            $data['totalBookings'] = Booking::where('worker_profile_id', $user->workerProfile->id)->count();
            $data['completedBookings'] = Booking::where('worker_profile_id', $user->workerProfile->id)->where('status', 'confirmed')->count();
        }

        $data['recentlyViewed'] = $user->recentlyViewed()->with(['user', 'category'])->get();

        return view('dashboard', $data);
    }
}
