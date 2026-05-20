<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="app()" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'M3alem') - Find Trusted Local Professionals</title>
    <meta name="description" content="@yield('meta_description', 'Connect with verified local professionals for all your home service needs. Quality work, fair prices, verified workers.')">
    <link rel="icon" type="image/png" href="/logo_M3alem_transparent.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                        accent: { 500: '#f59e0b', 600: '#d97706' }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.5s ease-out forwards',
                        'fade-in': 'fadeIn 0.4s ease-out forwards',
                        'scale-in': 'scaleIn 0.3s ease-out forwards',
                        'slide-down': 'slideDown 0.3s ease-out forwards',
                        'shimmer': 'shimmer 1.5s infinite',
                        'bounce-soft': 'bounceSoft 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        scaleIn: { '0%': { opacity: '0', transform: 'scale(0.95)' }, '100%': { opacity: '1', transform: 'scale(1)' } },
                        slideDown: { '0%': { opacity: '0', transform: 'translateY(-10px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        shimmer: { '0%': { backgroundPosition: '200% 0' }, '100%': { backgroundPosition: '-200% 0' } },
                        bounceSoft: { '0%': { transform: 'scale(0.9)' }, '50%': { transform: 'scale(1.02)' }, '100%': { transform: 'scale(1)' } },
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .glass { background: rgba(255,255,255,0.8); backdrop-filter: blur(12px); }
        .dark .glass { background: rgba(30,30,30,0.8); }
        .card-hover { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15); }
        .gradient-text { background: linear-gradient(135deg, #2563eb, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .hero-gradient { background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #7c3aed 100%); }
        .skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.5s infinite; }
        .dark .skeleton { background: linear-gradient(90deg, #2a2a2a 25%, #333 50%, #2a2a2a 75%); background-size: 200% 100%; }
        .stagger-1 { animation-delay: 0.05s; }
        .stagger-2 { animation-delay: 0.1s; }
        .stagger-3 { animation-delay: 0.15s; }
        .stagger-4 { animation-delay: 0.2s; }
        .stagger-5 { animation-delay: 0.25s; }
        .stagger-6 { animation-delay: 0.3s; }
        .stagger-7 { animation-delay: 0.35s; }
        .stagger-8 { animation-delay: 0.4s; }
        .stagger-9 { animation-delay: 0.45s; }
        .stagger-10 { animation-delay: 0.5s; }
        .stagger-11 { animation-delay: 0.55s; }
        .stagger-12 { animation-delay: 0.6s; }
        .search-input:focus { box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15); }
        .filter-chip { transition: all 0.2s ease; }
        .filter-chip:hover { transform: scale(1.05); }
        .filter-chip.active { background: linear-gradient(135deg, #2563eb, #3b82f6); color: white; border-color: transparent; }
        .page-transition { animation: fadeIn 0.3s ease-out; }
        .modal-overlay { background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a1a1a1; }
        .dark ::-webkit-scrollbar-track { background: #1a1a1a; }
        .dark ::-webkit-scrollbar-thumb { background: #444; }
    </style>
    @stack('styles')
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300" x-data="{ mobileMenu: false }">
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-300" :class="{ 'shadow-lg': window.scrollY > 10 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-brand-500/30 transition-all group-hover:scale-105">
                        <i class="fas fa-tools text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold gradient-text hidden sm:block">M3alem</span>
                </a>
                <div class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100' }}">Home</a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('categories.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100' }}">Categories</a>
                    <a href="{{ route('workers.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('workers.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100' }}">Find Workers</a>
                    @auth
                        @php
                            if (auth()->user()->role === 'worker' && auth()->user()->workerProfile) {
                                $unreadCount = \App\Models\Message::whereHas('conversation', fn($q) => $q->where('worker_profile_id', auth()->user()->workerProfile->id))->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
                            } else {
                                $unreadCount = \App\Models\Message::whereHas('conversation', fn($q) => $q->where('client_id', auth()->id()))->where('sender_id', '!=', auth()->id())->where('is_read', false)->count();
                            }
                        @endphp
                        <a href="{{ route('messages.index') }}" class="relative px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('messages.*') ? 'bg-brand-50 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100' }}">
                            <i class="fas fa-comment-dots mr-1"></i>Messages
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center font-bold">{{ min($unreadCount, 99) }}</span>
                            @endif
                        </a>
                    @endauth
                </div>
                <div class="flex items-center space-x-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" title="Toggle dark mode">
                        <i class="fas" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon text-gray-600'"></i>
                    </button>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors hidden sm:block">Dashboard</a>
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md cursor-pointer hover:scale-110 transition-transform" @click="mobileMenu = !mobileMenu">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors hidden sm:block">Login</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-brand-600 to-brand-700 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 transition-all hover:scale-105">Get Started</a>
                    @endauth
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="fas fa-bars text-gray-600 dark:text-gray-400"></i>
                    </button>
                </div>
            </div>
        </div>
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 shadow-lg" @click.away="mobileMenu = false">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Home</a>
                <a href="{{ route('categories.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Categories</a>
                <a href="{{ route('workers.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Find Workers</a>
                @auth
                <a href="{{ route('messages.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700"><i class="fas fa-comment-dots mr-1"></i>Messages</a>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-900/20">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 rounded-lg text-sm font-medium text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-900/20">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-16 page-transition min-h-screen">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl flex items-center justify-between">
                    <span class="flex items-center"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800"><i class="fas fa-times"></i></button>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Toast Container -->
    <div class="fixed bottom-4 right-4 z-50 space-y-2" x-data="toastStore()">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-x-8"
                 class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border max-w-sm"
                 :class="toast.type === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/30 border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300' : toast.type === 'error' ? 'bg-red-50 dark:bg-red-900/30 border-red-200 dark:border-red-800 text-red-800 dark:text-red-300' : 'bg-blue-50 dark:bg-blue-900/30 border-blue-200 dark:border-blue-800 text-blue-800 dark:text-blue-300'">
                <i class="fas" :class="toast.type === 'success' ? 'fa-check-circle text-emerald-500' : toast.type === 'error' ? 'fa-exclamation-circle text-red-500' : 'fa-info-circle text-blue-500'"></i>
                <p class="text-sm font-medium flex-1" x-text="toast.message"></p>
                <button @click="removeToast(toast.id)" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"><i class="fas fa-times text-xs"></i></button>
            </div>
        </template>
    </div>

    <!-- Mobile Bottom Nav -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 z-40 pb-safe">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('home') ? 'text-brand-600 dark:text-brand-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fas fa-home text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Home</span>
            </a>
            <a href="{{ route('categories.index') }}" class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('categories.*') ? 'text-brand-600 dark:text-brand-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fas fa-th-large text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Categories</span>
            </a>
            <a href="{{ route('workers.index') }}" class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('workers.*') ? 'text-brand-600 dark:text-brand-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fas fa-search text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Search</span>
            </a>
            @auth
            <a href="{{ route('messages.index') }}" class="flex flex-col items-center p-2 rounded-lg relative {{ request()->routeIs('messages.*') ? 'text-brand-600 dark:text-brand-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fas fa-comment-dots text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Messages</span>
                @if($unreadCount > 0)
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </a>
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'text-brand-600 dark:text-brand-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Profile</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="flex flex-col items-center p-2 rounded-lg text-gray-500 dark:text-gray-400">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px] mt-0.5 font-medium">Login</span>
            </a>
            @endauth
        </div>
    </nav>

    <footer class="bg-gray-900 dark:bg-gray-950 text-white mt-20 pb-20 md:pb-0">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-tools text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold">M3alem</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-md">Connect with trusted local professionals for all your home service needs. Quality work, fair prices, verified workers.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-gray-200">Services</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('categories.show', 1) }}" class="hover:text-white transition-colors">Painting</a></li>
                        <li><a href="{{ route('categories.show', 2) }}" class="hover:text-white transition-colors">Plumbing</a></li>
                        <li><a href="{{ route('categories.show', 3) }}" class="hover:text-white transition-colors">Electrical</a></li>
                        <li><a href="{{ route('categories.show', 5) }}" class="hover:text-white transition-colors">Cleaning</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-3 text-gray-200">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} M3alem. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        function app() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches),
            }
        }

        function toastStore() {
            return {
                toasts: [],
                addToast(message, type = 'success') {
                    const id = Date.now();
                    this.toasts.push({ id, message, type, show: true });
                    setTimeout(() => this.removeToast(id), 4000);
                },
                removeToast(id) {
                    const toast = this.toasts.find(t => t.id === id);
                    if (toast) toast.show = false;
                    setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, 300);
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
