@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center mb-8">
        <a href="{{ route('bookings.index') }}" class="text-gray-400 hover:text-gray-600 mr-4">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Complete Payment</h1>
            <p class="text-gray-500 mt-1">Secure payment via Stripe</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-sm">
                    {{ substr($worker->user->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 text-lg">{{ $worker->user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $worker->category->name }} · {{ $worker->city }}</p>
                </div>
            </div>
        </div>
        <div class="p-6 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Booking Date</span>
                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</span>
            </div>
            @if($booking->notes)
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Notes</span>
                <span class="font-medium text-gray-900 text-right max-w-xs">{{ $booking->notes }}</span>
            </div>
            @endif
            <div class="border-t border-gray-100 pt-3 flex justify-between">
                <span class="text-gray-900 font-semibold">Total</span>
                <span class="text-xl font-bold text-gray-900">{{ number_format($amount, 2) }} MAD</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div x-data="stripeCheckout()" x-init="init('{{ $stripeKey }}', '{{ route('payment.intent', $booking) }}', '{{ route('payment.success', $booking) }}', '{{ csrf_token() }}')">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Card Details</label>
                <div id="card-element" class="px-4 py-3 border border-gray-200 rounded-xl focus-within:ring-2 focus-within:ring-brand-500 focus-within:border-brand-500 transition-all"></div>
                <div id="card-errors" class="text-red-500 text-sm mt-2" role="alert"></div>
            </div>

            <div class="flex items-center mb-6 text-sm text-gray-500 bg-gray-50 rounded-xl px-4 py-3">
                <i class="fas fa-lock text-brand-500 mr-3"></i>
                <span>Your payment is secured via Stripe. We do not store your card details.</span>
            </div>

            <button @click="pay" :disabled="processing"
                    class="w-full bg-gradient-to-r from-brand-600 to-brand-700 text-white py-3.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <i class="fas fa-lock" x-show="!processing"></i>
                <i class="fas fa-spinner fa-spin" x-show="processing"></i>
                <span x-text="processing ? 'Processing...' : 'Pay {{ number_format($amount, 2) }} MAD'"></span>
            </button>

            <div x-show="error" x-cloak x-transition
                 class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span x-text="error"></span>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center gap-2 mt-6 text-xs text-gray-400">
        <i class="fab fa-cc-visa text-lg"></i>
        <i class="fab fa-cc-mastercard text-lg"></i>
        <i class="fab fa-cc-amex text-lg"></i>
        <span class="ml-2">Powered by Stripe</span>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
function stripeCheckout() {
    return {
        processing: false,
        error: '',
        stripe: null,
        card: null,
        clientSecret: '',
        successUrl: '',

        init(stripeKey, intentUrl, successUrl, csrfToken) {
            this.successUrl = successUrl;
            this.stripe = Stripe(stripeKey);

            const elements = this.stripe.elements({
                appearance: {
                    theme: 'stripe',
                    variables: {
                        colorPrimary: '#2563eb',
                        colorBackground: '#ffffff',
                        colorText: '#111827',
                        colorDanger: '#ef4444',
                        fontFamily: 'Inter, sans-serif',
                        borderRadius: '12px',
                    },
                }
            });

            this.card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#111827',
                        '::placeholder': { color: '#9ca3af' },
                    },
                },
            });
            this.card.mount('#card-element');

            this.card.on('change', (event) => {
                const displayError = document.getElementById('card-errors');
                displayError.textContent = event.error ? event.error.message : '';
            });
        },

        async pay() {
            this.processing = true;
            this.error = '';

            try {
                const res = await fetch('{{ route('payment.intent', $booking) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();

                if (!data.clientSecret) {
                    this.error = 'Failed to initialize payment. Please try again.';
                    this.processing = false;
                    return;
                }

                const { paymentIntent, error } = await this.stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: { card: this.card }
                });

                if (error) {
                    this.error = error.message;
                    this.processing = false;
                    return;
                }

                if (paymentIntent.status === 'succeeded') {
                    window.location.href = this.successUrl;
                } else {
                    this.error = 'Payment status: ' + paymentIntent.status;
                    this.processing = false;
                }
            } catch (e) {
                this.error = 'Something went wrong. Please try again.';
                this.processing = false;
            }
        }
    }
}
</script>
@endsection
