<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, WorkerProfile $worker)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $exists = Booking::where('worker_profile_id', $worker->id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['booking_date' => 'This date is already booked. Please choose another.']);
        }

        Booking::create([
            'client_id' => Auth::id(),
            'worker_profile_id' => $worker->id,
            'booking_date' => $request->booking_date,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return back()->with('success', 'Booking request sent! The worker will confirm shortly.');
    }

    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'worker' && $user->workerProfile) {
            $bookings = Booking::where('worker_profile_id', $user->workerProfile->id)
                ->with('client')->orderByDesc('created_at')->get();
        } else {
            $bookings = Booking::where('client_id', $user->id)
                ->with('workerProfile.user')->orderByDesc('created_at')->get();
        }
        return view('bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $user = Auth::user();
        $isWorker = $user->workerProfile && $booking->worker_profile_id === $user->workerProfile->id;

        abort_unless($isWorker || $booking->client_id === $user->id, 403);

        $request->validate(['status' => 'required|in:confirmed,cancelled']);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking ' . $request->status . '!');
    }

    public function getBookings(WorkerProfile $worker)
    {
        $bookings = Booking::where('worker_profile_id', $worker->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('booking_date')
            ->map(fn($d) => $d->format('Y-m-d'));

        return response()->json($bookings);
    }
}
