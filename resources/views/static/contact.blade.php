@extends('layouts.main')

@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with M3alem support team.')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Contact Us</h1>
        <p class="text-xl text-gray-500 dark:text-gray-400">We're here to help</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-brand-50 dark:bg-brand-900/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-envelope text-brand-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                    <p class="font-medium text-gray-900 dark:text-white">support@servicemarket.com</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-phone text-emerald-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                    <p class="font-medium text-gray-900 dark:text-white">+212 5XX-XXXXXX</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                    <p class="font-medium text-gray-900 dark:text-white">Casablanca, Morocco</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Send us a message</h3>
            <form class="space-y-4">
                <div>
                    <input type="text" placeholder="Your name" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:text-white">
                </div>
                <div>
                    <input type="email" placeholder="Your email" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:text-white">
                </div>
                <div>
                    <textarea rows="4" placeholder="Your message" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:text-white"></textarea>
                </div>
                <button type="button" class="w-full bg-brand-600 text-white py-3 rounded-xl font-semibold hover:bg-brand-700 transition-colors">Send Message</button>
            </form>
        </div>
    </div>
</div>
@endsection
