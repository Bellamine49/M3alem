@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="text-gray-500 mt-1">Manage your account and services</p>
        </div>
        <div class="flex items-center gap-3">
            @if(auth()->user()->workerProfile)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-1 flex">
                <a href="{{ route('dashboard', ['view' => 'client']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $view === 'client' ? 'bg-brand-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100' }}">
                    <i class="fas fa-user mr-1.5"></i>Client
                </a>
                <a href="{{ route('dashboard', ['view' => 'worker']) }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ $view === 'worker' ? 'bg-brand-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100' }}">
                    <i class="fas fa-briefcase mr-1.5"></i>Worker
                </a>
            </div>
            @endif
            <a href="{{ route('profile.edit') }}" class="bg-gradient-to-r from-brand-600 to-brand-700 text-white px-6 py-2.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all">
                <i class="fas fa-cog mr-2"></i>Settings
            </a>
        </div>
    </div>

    @if($view === 'worker' && auth()->user()->workerProfile)
        {{-- ==================== WORKER DASHBOARD ==================== --}}
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-check text-emerald-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Bookings</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBookings }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedBookings }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-accent-500/10 dark:bg-accent-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-accent-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rating</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->workerProfile->rating }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Reviews</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->workerProfile->total_reviews }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Upcoming Bookings --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-calendar-alt text-brand-600 mr-2"></i>Upcoming Work
                </h2>
                <a href="{{ route('bookings.index') }}" class="text-sm text-brand-600 dark:text-brand-400 hover:text-brand-700 font-medium">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            @if($upcomingBookings->isEmpty())
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No upcoming work</h3>
                <p class="text-gray-500 dark:text-gray-400">You'll see your bookings here once clients book your services.</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($upcomingBookings as $booking)
                <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-brand-200 dark:hover:border-brand-700 transition-all {{ $booking->status === 'confirmed' ? 'bg-emerald-50/50 dark:bg-emerald-900/10' : 'bg-amber-50/50 dark:bg-amber-900/10' }}">
                    <div class="flex items-center gap-4">
                        <div class="text-center min-w-[60px]">
                            <div class="text-sm font-bold text-brand-600 dark:text-brand-400 uppercase">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M') }}</div>
                            <div class="text-2xl font-extrabold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($booking->booking_date)->format('D') }}</div>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $booking->client->name }}</p>
                            @if($booking->notes)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">"{{ $booking->notes }}"</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $booking->status === 'confirmed' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800' : 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800' }}">
                            <i class="fas {{ $booking->status === 'confirmed' ? 'fa-check-circle' : 'fa-clock' }} mr-1"></i>
                            {{ ucfirst($booking->status) }}
                        </span>
                        @if($booking->status === 'pending')
                        <form action="{{ route('bookings.updateStatus', $booking) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs px-3 py-1.5 rounded-lg font-semibold transition-colors">
                                <i class="fas fa-check mr-1"></i>Confirm
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Quick Links for Worker --}}
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('messages.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-comment-dots text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Messages</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Inbox</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('bookings.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-alt text-emerald-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">All Bookings</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Schedule</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('profile.edit') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-user-edit text-brand-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Profile</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Edit Profile</p>
                    </div>
                </div>
            </a>
        </div>

    @else
        {{-- ==================== CLIENT DASHBOARD ==================== --}}
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <a href="{{ route('messages.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-comment-dots text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Messages</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Inbox</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('bookings.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-calendar-check text-emerald-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Bookings</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Schedule</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('favorites.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-heart text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Favorites</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()->favorites()->count() }}</p>
                    </div>
                </div>
            </a>
            <a href="{{ route('workers.index') }}" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 hover:shadow-md hover:border-brand-200 transition-all group">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-search text-brand-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Find Workers</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">Browse</p>
                    </div>
                </div>
            </a>
        </div>

        @if($recentlyViewed->isNotEmpty())
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recently Viewed</h2>
            <div class="flex gap-4 overflow-x-auto pb-4">
                @foreach($recentlyViewed as $worker)
                <a href="{{ route('workers.show', $worker) }}" class="flex-shrink-0 w-48 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 p-4 hover:shadow-md transition-all">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">{{ substr($worker->user->name, 0, 1) }}</div>
                        <div class="ml-2 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $worker->user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $worker->category->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400">
                        <i class="fas fa-star text-accent-500 mr-1"></i>{{ $worker->rating }} · {{ $worker->city }}
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user text-brand-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Account Type</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-accent-500/10 dark:bg-accent-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-accent-500 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rating</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()->workerProfile?->rating ?? '—' }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Reviews</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()->workerProfile?->total_reviews ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'client')
        <div class="bg-gradient-to-br from-brand-600 to-purple-600 rounded-2xl p-8 text-white">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-2xl font-bold mb-2">Start earning as a worker</h2>
                    <p class="text-blue-100 max-w-lg">Set up your professional profile, list your services and prices, and start receiving requests from clients in your area.</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-white text-brand-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-50 shadow-lg transition-all whitespace-nowrap">
                    Create Worker Profile
                </a>
            </div>
        </div>
        @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Your Worker Profile</h2>
            @if(auth()->user()->workerProfile)
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="inline-flex items-center px-3 py-1 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-sm font-medium rounded-lg">{{ auth()->user()->workerProfile->category->name }}</span>
                    <span class="ml-4 text-gray-600 dark:text-gray-400">{{ auth()->user()->workerProfile->city ?? 'No city set' }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-brand-600 dark:text-brand-400 hover:text-brand-700 font-medium text-sm">Edit Profile <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            @else
            <p class="text-gray-500 dark:text-gray-400">Complete your worker profile to start receiving clients.</p>
            <a href="{{ route('profile.edit') }}" class="inline-block mt-4 bg-brand-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-brand-700 transition-colors">Set Up Profile</a>
            @endif
        </div>
        @endif
    @endif
</div>
@endsection
