@extends('layouts.main')

@section('content')
<div class="bg-gradient-to-br from-brand-600 to-purple-700 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-20 w-64 h-64 bg-white rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 left-10 w-48 h-48 bg-purple-300 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">Find Workers</h1>
        <p class="text-blue-100 animate-fade-in-up" style="animation-delay: 0.1s;">Discover trusted professionals in your area</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10" x-data="workerSearch()">
    <div class="bg-white rounded-2xl shadow-xl p-4 md:p-6 mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
        <form action="{{ route('workers.index') }}" method="GET">
            <div class="flex flex-col md:flex-row gap-3 items-end">
                <div class="flex-1 relative">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Search</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Service, name, or city..." 
                               class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all">
                    </div>
                </div>
                
                <div class="w-full md:w-56 relative" @click.away="categoryOpen = false">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Category</label>
                    <button type="button" @click="categoryOpen = !categoryOpen" 
                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl hover:border-gray-300 transition-all text-left">
                        <span class="text-gray-700" x-text="selectedCategory || 'All Categories'"></span>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform" :class="{ 'rotate-180': categoryOpen }"></i>
                    </button>
                    <input type="hidden" name="category" :value="selectedCategoryId">
                    <div x-show="categoryOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                         class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-2">
                            <button type="button" @click="selectCategory('', 'All Categories')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedCategoryId === '' }">
                                All Categories
                            </button>
                            @foreach($categories as $cat)
                            <button type="button" @click="selectCategory('{{ $cat->id }}', '{{ $cat->name }}')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors flex items-center"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedCategoryId === '{{ $cat->id }}' }">
                                <span>{{ $cat->name }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-48 relative" @click.away="sortOpen = false">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Sort By</label>
                    <button type="button" @click="sortOpen = !sortOpen" 
                            class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl hover:border-gray-300 transition-all text-left">
                        <span class="text-gray-700" x-text="selectedSort || 'Recommended'"></span>
                        <i class="fas fa-chevron-down text-gray-400 text-sm transition-transform" :class="{ 'rotate-180': sortOpen }"></i>
                    </button>
                    <input type="hidden" name="sort" :value="selectedSortId">
                    <div x-show="sortOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                         class="absolute z-50 mt-2 w-full bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-2">
                            <button type="button" @click="selectSort('', 'Recommended')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedSortId === '' }">
                                Recommended
                            </button>
                            <button type="button" @click="selectSort('rating', 'Highest Rated')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedSortId === 'rating' }">
                                Highest Rated
                            </button>
                            <button type="button" @click="selectSort('price_asc', 'Price: Low → High')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedSortId === 'price_asc' }">
                                Price: Low → High
                            </button>
                            <button type="button" @click="selectSort('price_desc', 'Price: High → Low')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedSortId === 'price_desc' }">
                                Price: High → Low
                            </button>
                            <button type="button" @click="selectSort('experience', 'Most Experienced')" 
                                    class="w-full text-left px-3 py-2.5 rounded-lg text-sm hover:bg-gray-50 transition-colors"
                                    :class="{ 'bg-brand-50 text-brand-700 font-medium': selectedSortId === 'experience' }">
                                Most Experienced
                            </button>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="bg-gradient-to-r from-brand-600 to-brand-700 text-white px-8 py-3 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all hover:scale-105 active:scale-95 whitespace-nowrap">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>
    </div>

    <div class="flex items-center justify-between mb-6 animate-fade-in" style="animation-delay: 0.3s;">
        <p class="text-sm text-gray-500 dark:text-gray-400"><span x-text="{{ $workers->total() }}"></span> professionals found</p>
        <div class="flex items-center gap-1">
            <button @click="viewMode = 'grid'" :class="{ 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400': viewMode === 'grid', 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300': viewMode !== 'grid' }" class="p-2 rounded-lg transition-all" title="Grid view">
                <i class="fas fa-th-large"></i>
            </button>
            <button @click="viewMode = 'list'" :class="{ 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400': viewMode === 'list', 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300': viewMode !== 'list' }" class="p-2 rounded-lg transition-all hidden sm:block" title="List view">
                <i class="fas fa-list"></i>
            </button>
            <button @click="viewMode = 'map'; initMap()" :class="{ 'bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400': viewMode === 'map', 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300': viewMode !== 'map' }" class="p-2 rounded-lg transition-all" title="Map view">
                <i class="fas fa-map"></i>
            </button>
        </div>
    </div>

    <!-- Map View -->
    <div x-show="viewMode === 'map'" x-cloak class="mb-8 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm" style="height: 500px;">
        <div id="map" class="w-full h-full"></div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" :class="{ 'grid-cols-1': viewMode === 'list' }" x-show="viewMode !== 'map'">
        @forelse($workers as $index => $worker)
        <div x-show="!loading"
           x-transition:enter="transition ease-out duration-500"
           x-transition:enter-start="opacity-0 translate-y-8 scale-95"
           x-transition:enter-end="opacity-100 translate-y-0 scale-100"
           :style="'transition-delay: {{ $index * 0.05 }}s'"
           class="card-hover bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden group animate-fade-in-up opacity-0" style="animation-delay: {{ 0.3 + ($index * 0.05) }}s;">
            <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                    <a href="{{ route('workers.show', $worker) }}" class="flex items-center flex-1 min-w-0">
                        <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-brand-500/20 transition-transform duration-300 group-hover:scale-110 flex-shrink-0">
                            {{ substr($worker->user->name, 0, 1) }}
                        </div>
                        <div class="ml-4 min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-brand-600 transition-colors truncate">{{ $worker->user->name }}</h3>
                            <div class="flex items-center mt-1 flex-wrap gap-1">
                                <span class="inline-flex items-center px-2 py-0.5 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-xs font-medium rounded-md">{{ $worker->category->name }}</span>
                                @if($worker->is_verified)
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-medium rounded"><i class="fas fa-check-circle mr-0.5"></i>Verified</span>
                                @endif
                                @if($worker->instant_booking)
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-medium rounded"><i class="fas fa-bolt mr-0.5"></i>Instant</span>
                                @endif
                            </div>
                            @if($worker->response_time)
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1"><i class="fas fa-clock mr-1"></i>{{ $worker->response_time }}</p>
                            @endif
                        </div>
                    </a>
                    @auth
                    <form action="{{ route('favorites.toggle', $worker) }}" method="POST" class="ml-2 flex-shrink-0">
                        @csrf
                        <button type="submit" class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors {{ auth()->user()->favorites()->where('worker_profile_id', $worker->id)->exists() ? 'text-red-500' : 'text-gray-300 dark:text-gray-600 hover:text-red-400' }}">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                    @endauth
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
                    <span><i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i>{{ $worker->city ?? 'N/A' }}</span>
                    <span><i class="fas fa-briefcase mr-1.5 text-gray-400"></i>{{ $worker->experience_years }} yrs</span>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div>
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $worker->price_per_unit }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">{{ str_replace('_', ' ', $worker->price_unit) }}</span>
                    </div>
                    <a href="{{ route('workers.show', $worker) }}" class="text-brand-600 dark:text-brand-400 font-medium text-sm hover:text-brand-700 flex items-center">
                        View <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 animate-fade-in-up">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce-soft">
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers found</h3>
            <p class="text-gray-500">Try adjusting your search or filters</p>
        </div>
        @endforelse
    </div>
    
    @if($workers->hasPages())
    <div class="mt-10 flex justify-center animate-fade-in" style="animation-delay: 0.8s;">
        {{ $workers->withQueryString()->links() }}
    </div>
    @endif
</div>

<script>
let mapInitialized = false;
function initMap() {
    if (mapInitialized) return;
    mapInitialized = true;
    setTimeout(() => {
        const map = L.map('map').setView([32.0, -7.0], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);
        const workers = @json($mapData);
        const cityCoords = {
            'Casablanca': [33.5731, -7.5898], 'Rabat': [34.0209, -6.8416], 'Marrakech': [31.6295, -7.9811],
            'Fes': [34.0333, -5.0000], 'Tangier': [35.7595, -5.8340], 'Agadir': [30.4278, -9.5981],
            'Meknes': [33.8935, -5.5473]
        };
        workers.forEach(w => {
            const coords = cityCoords[w.city] || [32.0, -7.0];
            const marker = L.marker(coords).addTo(map);
            marker.bindPopup(`<a href="${w.url}" class="font-semibold">${w.name}</a><br>${w.category}<br>⭐ ${w.rating}`);
        });
        setTimeout(() => map.invalidateSize(), 100);
    }, 100);
}

function workerSearch() {
    return {
        categoryOpen: false,
        sortOpen: false,
        selectedCategory: '{{ request("category") ? $categories->firstWhere("id", request("category"))->name : "" }}',
        selectedCategoryId: '{{ request("category") ?? "" }}',
        selectedSort: '{{ request("sort") == "rating" ? "Highest Rated" : (request("sort") == "price_asc" ? "Price: Low → High" : (request("sort") == "price_desc" ? "Price: High → Low" : (request("sort") == "experience" ? "Most Experienced" : ""))) }}',
        selectedSortId: '{{ request("sort") ?? "" }}',
        viewMode: 'grid',
        loading: false,
        selectCategory(id, name) {
            this.selectedCategory = name;
            this.selectedCategoryId = id;
            this.categoryOpen = false;
        },
        selectSort(id, name) {
            this.selectedSort = name;
            this.selectedSortId = id;
            this.sortOpen = false;
        }
    }
}
</script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
