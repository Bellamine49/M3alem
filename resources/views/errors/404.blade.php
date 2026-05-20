@extends('layouts.main')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center">
        <div class="text-8xl font-bold text-gray-200 dark:text-gray-700 mb-4">404</div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Page not found</h1>
        <p class="text-gray-500 dark:text-gray-400 mb-8">The page you're looking for doesn't exist or has been moved.</p>
        <a href="{{ route('home') }}" class="inline-flex items-center bg-brand-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-brand-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Home
        </a>
    </div>
</div>
@endsection
