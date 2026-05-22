<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createIntent(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        $amount = $booking->counter_price ?? $booking->proposed_price ?? $booking->workerProfile->price_per_unit;

        $intent = PaymentIntent::create([
            'amount' => (int) ($amount * 100),
            'currency' => 'mad',
            'metadata' => [
                'booking_id' => $booking->id,
                'client_id' => Auth::id(),
                'worker_id' => $booking->worker_profile_id,
            ],
        ]);

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'client_id' => Auth::id(),
                'worker_profile_id' => $booking->worker_profile_id,
                'amount' => $amount,
                'currency' => 'MAD',
                'stripe_payment_intent_id' => $intent->id,
                'status' => 'pending',
            ]
        );

        return response()->json([
            'clientSecret' => $intent->client_secret,
            'amount' => $amount,
        ]);
    }

    public function confirm(Request $request, Booking $booking)
    {
        $payment = $booking->payment;
        if (!$payment) {
            return back()->withErrors(['payment' => 'No payment found.']);
        }

        $intent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);

        if ($intent->status === 'succeeded') {
            $payment->update(['status' => 'paid', 'payment_method' => 'card']);
            $booking->update(['status' => 'confirmed']);
            return back()->with('success', 'Payment successful! Booking confirmed.');
        }

        return back()->withErrors(['payment' => 'Payment not successful. Status: ' . $intent->status]);
    }

    public function history()
    {
        $user = Auth::user();
        if ($user->role === 'worker' && $user->workerProfile) {
            $payments = Payment::where('worker_profile_id', $user->workerProfile->id)
                ->with('booking', 'client')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $payments = Payment::where('client_id', $user->id)
                ->with('booking', 'workerProfile.user')
                ->orderByDesc('created_at')
                ->get();
        }

        return view('payments.index', compact('payments'));
    }
}
