@extends('layouts.main')

@section('title', 'My Favorites')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Favorites</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Workers you've saved</p>
        </div>
    </div>

    @if($favorites->isEmpty())
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-16 text-center">
        <div class="w-24 h-24 bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 rounded-full flex items-center justify-center mx-auto mb-5">
            <i class="fas fa-heart text-red-300 dark:text-red-500 text-3xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No favorites yet</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Save workers you like to find them quickly later</p>
        <a href="{{ route('workers.index') }}" class="inline-flex items-center bg-brand-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-brand-700 transition-colors">
            <i class="fas fa-search mr-2"></i>Find Workers
        </a>
    </div>
    @else
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $worker)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <a href="{{ route('workers.show', $worker) }}" class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-brand-500/20">
                            {{ substr($worker->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 transition-colors">{{ $worker->user->name }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-xs font-medium rounded-md mt-1">{{ $worker->category->name }}</span>
                        </div>
                    </a>
                    <form action="{{ route('favorites.toggle', $worker) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 transition-colors p-1">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                </div>
                <div class="flex items-center mb-3">
                    <div class="flex text-accent-500 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($worker->rating) ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900 dark:text-white">{{ $worker->rating }}</span>
                    <span class="ml-1 text-sm text-gray-400">({{ $worker->total_reviews }})</span>
                </div>
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4 space-x-4">
                    <span><i class="fas fa-map-marker-alt mr-1.5"></i>{{ $worker->city ?? 'N/A' }}</span>
                    <span><i class="fas fa-briefcase mr-1.5"></i>{{ $worker->experience_years }} yrs</span>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $worker->price_per_unit }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">{{ str_replace('_', ' ', $worker->price_unit) }}</span>
                    </div>
                    <a href="{{ route('workers.show', $worker) }}" class="text-brand-600 dark:text-brand-400 font-medium text-sm hover:text-brand-700">View <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($favorites->hasPages())
    <div class="mt-10 flex justify-center">{{ $favorites->links() }}</div>
    @endif
    @endif
</div>
@endsection
