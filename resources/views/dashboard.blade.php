@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="text-gray-500 mt-1">Manage your account and services</p>
        </div>
        <a href="{{ route('profile.edit') }}" class="bg-gradient-to-r from-brand-600 to-brand-700 text-white px-6 py-2.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all">
            <i class="fas fa-cog mr-2"></i>Settings
        </a>
    </div>

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

    @php $recentlyViewed = auth()->user()->recentlyViewed()->with(['user', 'category'])->get(); @endphp
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
</div>
@endsection
