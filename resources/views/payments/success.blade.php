@extends('layouts.main')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12">
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check-circle text-emerald-500 text-4xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Payment Successful!</h1>
        <p class="text-gray-500 mb-8">Your booking has been confirmed and the worker has been notified.</p>

        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left max-w-sm mx-auto">
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Booking</span>
                <span class="font-medium text-gray-900">#{{ $booking->id }}</span>
            </div>
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Date</span>
                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M j, Y') }}</span>
            </div>
            @if($payment)
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500">Amount Paid</span>
                <span class="font-semibold text-emerald-600">{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Method</span>
                <span class="font-medium text-gray-900 capitalize">{{ $payment->payment_method ?? 'Card' }}</span>
            </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('bookings.index') }}" class="bg-brand-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-brand-700 transition-all">
                <i class="fas fa-calendar-check mr-2"></i>View My Bookings
            </a>
            <a href="{{ route('payments.index') }}" class="bg-gray-900 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-800 transition-all">
                <i class="fas fa-receipt mr-2"></i>Payment History
            </a>
        </div>
    </div>
</div>
@endsection
