@extends('layouts.main')

@section('title', 'About Us')
@section('meta_description', 'Learn about M3alem - connecting homeowners with trusted local professionals.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">About M3alem</h1>
        <p class="text-xl text-gray-500 dark:text-gray-400">Connecting you with trusted local professionals</p>
    </div>

    <div class="prose dark:prose-invert max-w-none">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">M3alem was founded with a simple goal: make it easy to find reliable, skilled professionals for your home service needs. We believe everyone deserves access to quality work at fair prices.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                <div class="w-16 h-16 bg-brand-50 dark:bg-brand-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-brand-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Verified Workers</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">All professionals are verified and reviewed by real customers</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                <div class="w-16 h-16 bg-accent-50 dark:bg-accent-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tags text-accent-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Transparent Pricing</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">See prices upfront. Compare and choose what fits your budget</p>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-star text-emerald-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Quality Guaranteed</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Read real reviews and ratings before you book</p>
            </div>
        </div>

        <div class="bg-gradient-to-br from-brand-600 to-purple-600 rounded-2xl p-8 text-white text-center">
            <h2 class="text-2xl font-bold mb-4">Join Our Community</h2>
            <p class="text-blue-100 mb-6">Whether you're looking for help or offering your skills, M3alem is for you.</p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-brand-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-50 transition-colors">Get Started Free</a>
        </div>
    </div>
</div>
@endsection
