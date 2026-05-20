@extends('layouts.main')

@section('content')
<div class="bg-gradient-to-br from-brand-600 to-purple-700 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-sm font-medium text-blue-100 hover:text-white mb-4 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to categories
        </a>
        <div class="flex items-center">
            <span class="text-4xl mr-4">{{ $category->icon ?? '🔧' }}</span>
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $category->name }}</h1>
                <p class="text-blue-100 mt-1">{{ $category->description ?? '' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-sm text-gray-500 mb-6">{{ $workers->total() }} professionals available</p>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($workers as $worker)
        <a href="{{ route('workers.show', $worker) }}" class="card-hover bg-white rounded-2xl border border-gray-100 overflow-hidden group">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-brand-500/20">
                            {{ substr($worker->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h3 class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors">{{ $worker->user->name }}</h3>
                            <span class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-1"></i>{{ $worker->city ?? 'N/A' }}</span>
                        </div>
                    </div>
                    @if($worker->is_available)
                    <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-full">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5"></span>Available
                    </span>
                    @endif
                </div>
                <div class="flex items-center mb-3">
                    <div class="flex text-accent-500 text-sm">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star{{ $i <= round($worker->rating) ? '' : '-o' }}"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-900">{{ $worker->rating }}</span>
                    <span class="ml-1 text-sm text-gray-400">({{ $worker->total_reviews }})</span>
                </div>
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div>
                        <span class="text-2xl font-bold text-gray-900">{{ $worker->price_per_unit }}</span>
                        <span class="text-sm text-gray-500 ml-1">{{ str_replace('_', ' ', $worker->price_unit) }}</span>
                    </div>
                    <span class="text-brand-600 font-medium text-sm">View <i class="fas fa-arrow-right ml-1"></i></span>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers yet</h3>
            <p class="text-gray-500">Be the first to offer this service!</p>
        </div>
        @endforelse
    </div>
    @if($workers->hasPages())
    <div class="mt-10 flex justify-center">{{ $workers->links() }}</div>
    @endif
</div>
@endsection
