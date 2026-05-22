<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function checkout(Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->price_status !== 'accepted' && !$booking->proposed_price && !$booking->counter_price) {
            return redirect()->route('bookings.index')->withErrors(['payment' => 'Please agree on a price first.']);
        }

        $worker = $booking->workerProfile()->with('user', 'category')->first();
        $amount = $booking->counter_price ?? $booking->proposed_price ?? $worker->price_per_unit;

        return view('payments.checkout', [
            'booking' => $booking,
            'worker' => $worker,
            'amount' => $amount,
            'stripeKey' => config('services.stripe.key'),
        ]);
    }

    public function createIntent(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        $amount = $booking->counter_price ?? $booking->proposed_price ?? $booking->workerProfile->price_per_unit;

        $existingPayment = $booking->payment;
        if ($existingPayment && $existingPayment->stripe_payment_intent_id) {
            try {
                $intent = PaymentIntent::retrieve($existingPayment->stripe_payment_intent_id);
                if ($intent->status === 'requires_payment_method' || $intent->status === 'requires_confirmation') {
                    return response()->json([
                        'clientSecret' => $intent->client_secret,
                        'paymentId' => $existingPayment->id,
                        'amount' => $amount,
                    ]);
                }
            } catch (\Exception $e) {
                // Intent expired or invalid, create new one
            }
        }

        $intent = PaymentIntent::create([
            'amount' => (int) ($amount * 100),
            'currency' => 'mad',
            'metadata' => [
                'booking_id' => $booking->id,
                'client_id' => Auth::id(),
                'worker_id' => $booking->worker_profile_id,
            ],
            'description' => 'Booking #' . $booking->id . ' - ' . $booking->workerProfile->user->name,
        ]);

        $payment = Payment::updateOrCreate(
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
            'paymentId' => $payment->id,
            'amount' => $amount,
        ]);
    }

    public function success(Request $request, Booking $booking)
    {
        if ($booking->client_id !== Auth::id()) {
            abort(403);
        }

        $payment = $booking->payment;
        if (!$payment || $payment->status !== 'paid') {
            if ($payment && $payment->stripe_payment_intent_id) {
                try {
                    $intent = PaymentIntent::retrieve($payment->stripe_payment_intent_id);
                    if ($intent->status === 'succeeded') {
                        $payment->update(['status' => 'paid', 'payment_method' => 'card']);
                        $booking->update(['status' => 'confirmed']);
                    }
                } catch (\Exception $e) {
                    //
                }
            }
        }

        return view('payments.success', compact('booking', 'payment'));
    }

    public function webhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook.secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook verification failed'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $intent = $event->data->object;
                $payment = Payment::where('stripe_payment_intent_id', $intent->id)->first();
                if ($payment && $payment->status !== 'paid') {
                    $payment->update([
                        'status' => 'paid',
                        'payment_method' => $intent->payment_method_types[0] ?? 'card',
                    ]);
                    $payment->booking->update(['status' => 'confirmed']);
                }
                break;

            case 'payment_intent.payment_failed':
                $intent = $event->data->object;
                $payment = Payment::where('stripe_payment_intent_id', $intent->id)->first();
                if ($payment) {
                    $payment->update(['status' => 'failed']);
                }
                break;
        }

        return response()->json(['received' => true]);
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
