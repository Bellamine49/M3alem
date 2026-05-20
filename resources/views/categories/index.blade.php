@extends('layouts.main')

@section('content')
<div class="bg-gradient-to-br from-brand-600 to-purple-700 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Service Categories</h1>
        <p class="text-blue-100">Browse professionals by service type</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
        <a href="{{ route('categories.show', $category) }}" class="card-hover bg-white rounded-2xl border border-gray-100 p-6 group">
            <div class="w-16 h-16 bg-gradient-to-br from-brand-50 to-purple-50 rounded-2xl flex items-center justify-center text-3xl mb-4 group-hover:scale-110 transition-transform shadow-sm">
                {{ $category->icon ?? '🔧' }}
            </div>
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-brand-600 transition-colors">{{ $category->name }}</h3>
            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $category->description ?? 'Professional services' }}</p>
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <span class="text-sm font-medium text-brand-600">{{ $category->worker_profiles_count }} workers</span>
                <i class="fas fa-arrow-right text-gray-400 group-hover:text-brand-600 group-hover:translate-x-1 transition-all"></i>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection
