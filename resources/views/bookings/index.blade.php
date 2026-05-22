@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
            <p class="text-gray-500 mt-1">Manage your service bookings</p>
        </div>
    </div>

    @if($bookings->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No bookings yet</h3>
        <p class="text-gray-500">Find a worker and book their services!</p>
        <a href="{{ route('workers.index') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-brand-700 transition-colors">Find Workers</a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($bookings as $booking)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition-all">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-brand-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold shadow-sm flex-shrink-0">
                        @if(auth()->user()->role === 'worker')
                            {{ substr($booking->client->name, 0, 1) }}
                        @else
                            {{ substr($booking->workerProfile->user->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">
                            @if(auth()->user()->role === 'worker')
                                {{ $booking->client->name }}
                            @else
                                {{ $booking->workerProfile->user->name }}
                                <span class="text-sm font-normal text-gray-500">- {{ $booking->workerProfile->category->name }}</span>
                            @endif
                        </h3>
                        <div class="flex items-center mt-1 text-sm text-gray-500">
                            <i class="fas fa-calendar-day mr-2 text-brand-500"></i>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}
                        </div>
                        @if($booking->notes)
                        <p class="text-sm text-gray-400 mt-2 italic">"{{ $booking->notes }}"</p>
                        @endif
                        @if($booking->proposed_price)
                        <p class="text-sm text-gray-500 mt-1"><i class="fas fa-tag text-brand-500 mr-1"></i>Proposed: <strong>{{ number_format($booking->proposed_price, 2) }}</strong></p>
                        @endif
                        @if($booking->counter_price)
                        <p class="text-sm text-gray-500 mt-1"><i class="fas fa-exchange-alt text-accent-500 mr-1"></i>Counter: <strong>{{ number_format($booking->counter_price, 2) }}</strong></p>
                        @endif
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    @php
                        $statusClasses = ['pending' => 'bg-amber-50 text-amber-700 border-amber-200', 'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'cancelled' => 'bg-red-50 text-red-700 border-red-200', 'paid' => 'bg-emerald-50 text-emerald-700 border-emerald-200'];
                        $statusIcons = ['pending' => 'fa-clock', 'confirmed' => 'fa-check-circle', 'cancelled' => 'fa-times-circle', 'paid' => 'fa-credit-card'];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $statusClasses[$booking->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}">
                        <i class="fas {{ $statusIcons[$booking->status] ?? 'fa-question' }} mr-1"></i>
                        {{ ucfirst($booking->status) }}
                    </span>
                    @if($booking->price_status === 'worker_countered' && auth()->id() === $booking->client_id)
                    <div class="mt-2">
                        <form action="{{ route('bookings.acceptPrice', $booking) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-emerald-500 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-emerald-600 transition-colors"><i class="fas fa-check mr-1"></i>Accept Price ({{ number_format($booking->counter_price, 2) }})</button>
                        </form>
                    </div>
                    @endif
                    @if($booking->price_status === 'accepted' && !$booking->payment)
                    <div class="mt-2">
                        <div x-data="paymentHandler('{{ route('payment.intent', $booking) }}', '{{ route('payment.confirm', $booking) }}')">
                            <button @click="pay" :disabled="loading" class="w-full bg-gradient-to-r from-brand-600 to-brand-700 text-white text-xs px-4 py-2 rounded-lg font-semibold hover:from-brand-700 hover:to-brand-800 transition-all shadow-sm" :class="{ 'opacity-50': loading }">
                                <i class="fas fa-credit-card mr-1"></i><span x-text="loading ? 'Processing...' : 'Pay Now'"></span>
                            </button>
                            <div x-show="error" x-cloak x-text="error" class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>
                    @endif
                    @if($booking->payment && $booking->payment->status === 'paid')
                    <div class="mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-lg">
                            <i class="fas fa-check-circle mr-1"></i>Paid {{ number_format($booking->payment->amount, 2) }}
                        </span>
                    </div>
                    @endif
                    @if($booking->status === 'pending')
                    <div class="mt-3 flex space-x-2 justify-end">
                        @if(auth()->user()->role === 'worker')
                        <form action="{{ route('bookings.updateStatus', $booking) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="bg-emerald-500 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-emerald-600 transition-colors"><i class="fas fa-check mr-1"></i>Confirm</button>
                        </form>
                        <div x-data="{ showCounter: false }" class="inline relative">
                            <button @click="showCounter = !showCounter" class="bg-accent-500 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-accent-600 transition-colors"><i class="fas fa-exchange-alt mr-1"></i>Counter</button>
                            <form x-show="showCounter" @click.away="showCounter = false" action="{{ route('bookings.counterOffer', $booking) }}" method="POST" class="absolute right-0 top-full mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-3 z-10 w-48" x-cloak>
                                @csrf
                                <input type="number" name="counter_price" step="0.01" min="0" required placeholder="Your price" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm mb-2">
                                <button type="submit" class="w-full bg-accent-500 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-accent-600">Send Counter Offer</button>
                            </form>
                        </div>
                        @endif
                        <form action="{{ route('bookings.updateStatus', $booking) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg font-semibold hover:bg-red-600 transition-colors"><i class="fas fa-times mr-1"></i>Cancel</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
<script>
function paymentHandler(intentUrl, confirmUrl) {
    return {
        loading: false,
        error: '',
        async pay() {
            this.loading = true;
            this.error = '';
            try {
                const res = await fetch(intentUrl, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                const data = await res.json();
                if (data.clientSecret) {
                    window.location.href = confirmUrl;
                }
            } catch (e) {
                this.error = 'Payment failed. Try again.';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
