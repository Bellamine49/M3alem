@extends('layouts.main')

@section('content')
<div class="hero-gradient relative z-30" x-data="homeSearch()">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-purple-300 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 1.5s;"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 relative z-10">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-sm font-medium mb-6 border border-white/20 animate-fade-in-up">
                <i class="fas fa-sparkles mr-2 text-accent-500"></i>Trusted by 10,000+ homeowners
            </div>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                Find the perfect <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent-500 to-orange-400">professional</span> for your home
            </h1>
            <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">From painting to plumbing, connect with verified local workers. Compare prices, read reviews, and book with confidence.</p>
            
            <form action="{{ route('workers.index') }}" method="GET" class="mx-auto animate-fade-in-up" style="animation-delay: 0.3s; max-width: 700px;">
                <input type="hidden" name="search" :value="selectedService">
                <input type="hidden" name="category" :value="selectedServiceId">
                <input type="hidden" name="min_price" :value="minPrice">
                <input type="hidden" name="max_price" :value="maxPrice">
                <div class="bg-white rounded-full shadow-2xl shadow-black/20 flex items-stretch h-14 transition-all duration-300" :class="{ 'ring-2 ring-brand-500/30 shadow-3xl': activeSegment }">
                    <!-- Service -->
                    <div class="relative flex-1 min-w-0" @click.away="closeSegment('service')">
                        <button type="button" @click="toggleSegment('service')" 
                                class="w-full h-full px-5 text-left rounded-l-full transition-colors hover:bg-gray-50"
                                :class="{ 'bg-gray-50': activeSegment === 'service' }">
                            <p class="text-[10px] font-bold text-gray-900 tracking-wide uppercase">Service</p>
                            <p class="text-sm text-gray-500 truncate mt-0.5" x-text="selectedService || 'Search services'"></p>
                        </button>
                        <div x-show="activeSegment === 'service'" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                            <div class="p-4 max-h-80 overflow-y-auto">
                                <div class="grid grid-cols-2 gap-2">
                                    <template x-for="suggestion in suggestions" :key="suggestion.id">
                                        <button type="button" @click="selectService(suggestion)"
                                                class="flex flex-col items-center p-3 rounded-xl hover:bg-gray-50 transition-all text-center group"
                                                :class="{ 'bg-brand-50 ring-2 ring-brand-500/20': selectedServiceId == suggestion.id }">
                                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition-transform" x-text="suggestion.icon || ''"></div>
                                            <p class="text-xs font-medium text-gray-900 leading-tight" x-text="suggestion.name"></p>
                                            <p class="text-[10px] text-gray-400 mt-0.5" x-text="suggestion.count + ' workers'"></p>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-px bg-gray-200 my-3 flex-shrink-0" x-show="activeSegment !== 'service'"></div>

                    <!-- City -->
                    <div class="relative flex-1 min-w-0" @click.away="closeSegment('city')">
                        <button type="button" @click="toggleSegment('city')" 
                                class="w-full h-full px-5 text-left transition-colors hover:bg-gray-50"
                                :class="{ 'bg-gray-50': activeSegment === 'city' }">
                            <p class="text-[10px] font-bold text-gray-900 tracking-wide uppercase">City</p>
                            <p class="text-sm text-gray-500 truncate mt-0.5" x-text="selectedCity || 'Where?'"></p>
                            <input type="hidden" name="city" :value="selectedCity">
                        </button>
                        <div x-show="activeSegment === 'city'" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                            <div class="p-3">
                                <div class="relative mb-3">
                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                    <input type="text" x-model="citySearch" placeholder="Search city..." 
                                           class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                                </div>
                                <div class="max-h-48 overflow-y-auto">
                                    <button type="button" @click="selectedCity = ''; activeSegment = null" 
                                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors"
                                            :class="{ 'bg-brand-50 text-brand-700': selectedCity === '' }">
                                        <i class="fas fa-globe text-gray-400"></i>
                                        <span class="text-sm font-medium">All cities</span>
                                    </button>
                                    <template x-for="city in filteredCities" :key="city">
                                        <button type="button" @click="selectedCity = city; activeSegment = null" 
                                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors"
                                                :class="{ 'bg-brand-50 text-brand-700': selectedCity === city }">
                                            <i class="fas fa-map-marker-alt text-brand-500"></i>
                                            <span class="text-sm font-medium flex-1" x-text="city"></span>
                                            <i class="fas fa-check text-brand-600 text-xs" x-show="selectedCity === city"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-px bg-gray-200 my-3 flex-shrink-0" x-show="activeSegment !== 'city'"></div>

                    <!-- Budget -->
                    <div class="relative flex-1 min-w-0" @click.away="closeSegment('budget')">
                        <button type="button" @click="toggleSegment('budget')" 
                                class="w-full h-full px-5 text-left transition-colors hover:bg-gray-50"
                                :class="{ 'bg-gray-50': activeSegment === 'budget' }">
                            <p class="text-[10px] font-bold text-gray-900 tracking-wide uppercase">Budget</p>
                            <p class="text-sm text-gray-500 truncate mt-0.5" x-text="budgetDisplay"></p>
                        </button>
                        <div x-show="activeSegment === 'budget'" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50 w-80">
                            <div class="p-5">
                                <p class="text-sm font-semibold text-gray-900 mb-4">Price range</p>
                                
                                <!-- Histogram bars -->
                                <div class="flex items-end justify-between h-16 mb-4 px-1">
                                    <template x-for="(bar, i) in histogramBars" :key="i">
                                        <div class="flex flex-col items-center gap-1 flex-1">
                                            <div class="w-full rounded-t transition-all" 
                                                 :class="bar.active ? 'bg-brand-600' : 'bg-gray-200'"
                                                 :style="'height: ' + bar.height + '%'"
                                                 @click="setBudgetFromBar(bar.min, bar.max)">
                                            </div>
                                            <span class="text-[9px] text-gray-400" x-text="bar.label"></span>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Range inputs -->
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex-1">
                                        <label class="text-[10px] font-semibold text-gray-500 uppercase">Min</label>
                                        <input type="number" x-model.number="minPrice" :min="0" :max="maxPrice" 
                                               class="w-full mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-center focus:ring-2 focus:ring-brand-500">
                                    </div>
                                    <span class="text-gray-300 mt-4">—</span>
                                    <div class="flex-1">
                                        <label class="text-[10px] font-semibold text-gray-500 uppercase">Max</label>
                                        <input type="number" x-model.number="maxPrice" :min="minPrice" 
                                               class="w-full mt-1 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-center focus:ring-2 focus:ring-brand-500">
                                    </div>
                                </div>
                                
                                <!-- Quick presets -->
                                <div class="flex gap-2">
                                    <template x-for="preset in budgetPresets" :key="preset.label">
                                        <button type="button" @click="minPrice = preset.min; maxPrice = preset.max"
                                                class="flex-1 px-2 py-1.5 text-xs font-medium rounded-lg transition-all"
                                                :class="minPrice === preset.min && maxPrice === preset.max ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                                x-text="preset.label">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search button -->
                    <button type="submit" class="flex items-center justify-center w-12 h-12 bg-brand-600 rounded-full text-white hover:bg-brand-700 transition-all hover:scale-105 active:scale-95 shadow-lg shadow-brand-500/30 my-auto mr-1.5 flex-shrink-0">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10" x-data="{ activeCategory: null }">
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 animate-fade-in-up" style="animation-delay: 0.4s;">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Popular Services</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($categories as $index => $category)
            <a href="{{ route('categories.show', $category) }}" 
               class="group flex flex-col items-center p-4 rounded-xl hover:bg-gray-50 transition-all duration-300 animate-fade-in-up opacity-0 stagger-{{ $index + 1 }}"
               @mouseenter="activeCategory = {{ $category->id }}" @mouseleave="activeCategory = null">
                <div class="w-14 h-14 bg-gradient-to-br from-brand-50 to-purple-50 rounded-2xl flex items-center justify-center text-2xl mb-3 transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg shadow-sm"
                     :class="{ 'scale-110 shadow-lg': activeCategory === {{ $category->id }} }">
                    {{ $category->icon ?? '🔧' }}
                </div>
                <span class="text-sm font-medium text-gray-700 text-center group-hover:text-brand-600 transition-colors">{{ $category->name }}</span>
                <span class="text-xs text-gray-400 mt-1">{{ $category->worker_profiles_count }} workers</span>
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="{ hoveredCard: null }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Top Rated Professionals</h2>
            <p class="text-gray-500 mt-1">Hand-picked workers with excellent reviews</p>
        </div>
        <a href="{{ route('workers.index') }}" class="hidden md:flex items-center text-brand-600 hover:text-brand-700 font-medium transition-colors group">
            View all workers <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($topWorkers as $index => $worker)
        <div class="card-hover bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden group animate-fade-in-up opacity-0 stagger-{{ $index + 1 }}">
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
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-[10px] font-medium rounded" title="Verified"><i class="fas fa-check-circle mr-0.5"></i>Verified</span>
                                @endif
                                @if($worker->instant_booking)
                                <span class="inline-flex items-center px-1.5 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[10px] font-medium rounded" title="Instant booking"><i class="fas fa-bolt mr-0.5"></i>Instant</span>
                                @endif
                            </div>
                            @if($worker->response_time)
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1"><i class="fas fa-clock mr-1"></i>Usually responds in {{ $worker->response_time }}</p>
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
                
                <div class="flex items-center mb-4">
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
        @endforeach
    </div>
    
    <div class="mt-8 text-center md:hidden">
        <a href="{{ route('workers.index') }}" class="inline-flex items-center text-brand-600 hover:text-brand-700 font-medium group">
            View all workers <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</div>

<script>
function homeSearch() {
    return {
        activeSegment: null,
        selectedService: '',
        selectedServiceId: '',
        selectedCity: '',
        citySearch: '',
        minPrice: 0,
        maxPrice: 5000,
        cities: @json($cities),
        suggestions: @json($suggestions),
        budgetPresets: [
            { label: 'Budget', min: 0, max: 200 },
            { label: 'Standard', min: 200, max: 1000 },
            { label: 'Premium', min: 1000, max: 5000 }
        ],
        get filteredCities() {
            if (!this.citySearch) return this.cities;
            return this.cities.filter(c => c.toLowerCase().includes(this.citySearch.toLowerCase()));
        },
        get budgetDisplay() {
            if (this.minPrice === 0 && this.maxPrice === 5000) return 'Any price';
            if (this.minPrice === 0) return 'Up to ' + this.maxPrice + ' MAD';
            if (this.maxPrice === 5000) return this.minPrice + '+ MAD';
            return this.minPrice + ' - ' + this.maxPrice + ' MAD';
        },
        get histogramBars() {
            const ranges = [
                { min: 0, max: 100, label: '<100' },
                { min: 100, max: 200, label: '100' },
                { min: 200, max: 500, label: '200' },
                { min: 500, max: 1000, label: '500' },
                { min: 1000, max: 2000, label: '1K' },
                { min: 2000, max: 5000, label: '2K+' }
            ];
            return ranges.map(r => ({
                ...r,
                height: 20 + Math.random() * 80,
                active: this.minPrice <= r.max && this.maxPrice >= r.min
            }));
        },
        toggleSegment(seg) {
            this.activeSegment = this.activeSegment === seg ? null : seg;
        },
        closeSegment(seg) {
            if (this.activeSegment === seg) this.activeSegment = null;
        },
        selectService(suggestion) {
            this.selectedService = suggestion.name;
            this.selectedServiceId = suggestion.id;
            this.activeSegment = null;
        },
        setBudgetFromBar(min, max) {
            this.minPrice = min;
            this.maxPrice = max;
        }
    }
}
</script>

<div class="bg-gradient-to-br from-gray-900 to-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold text-white">Why choose ServiceMarket?</h2>
            <p class="text-gray-400 mt-2">We make finding reliable help easy and safe</p>
        </div>
        <div class="grid md:grid-cols-3 gap-8" x-data="{ hoveredFeature: null }">
            <div class="text-center group" @mouseenter="hoveredFeature = 1" @mouseleave="hoveredFeature = null">
                <div class="w-16 h-16 bg-brand-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:bg-brand-500/20 group-hover:scale-110"
                     :class="{ 'bg-brand-500/20 scale-110': hoveredFeature === 1 }">
                    <i class="fas fa-shield-alt text-brand-400 text-2xl transition-transform duration-300" :class="{ 'scale-110': hoveredFeature === 1 }"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Verified Workers</h3>
                <p class="text-gray-400 text-sm">All professionals are verified and reviewed by real customers</p>
            </div>
            <div class="text-center group" @mouseenter="hoveredFeature = 2" @mouseleave="hoveredFeature = null">
                <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:bg-purple-500/20 group-hover:scale-110"
                     :class="{ 'bg-purple-500/20 scale-110': hoveredFeature === 2 }">
                    <i class="fas fa-tags text-purple-400 text-2xl transition-transform duration-300" :class="{ 'scale-110': hoveredFeature === 2 }"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Transparent Pricing</h3>
                <p class="text-gray-400 text-sm">See prices upfront. Compare and choose what fits your budget</p>
            </div>
            <div class="text-center group" @mouseenter="hoveredFeature = 3" @mouseleave="hoveredFeature = null">
                <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:bg-emerald-500/20 group-hover:scale-110"
                     :class="{ 'bg-emerald-500/20 scale-110': hoveredFeature === 3 }">
                    <i class="fas fa-star text-emerald-400 text-2xl transition-transform duration-300" :class="{ 'scale-110': hoveredFeature === 3 }"></i>
                </div>
                <h3 class="text-lg font-semibold text-white mb-2">Quality Guaranteed</h3>
                <p class="text-gray-400 text-sm">Read real reviews and ratings before you book</p>
            </div>
        </div>
    </div>
</div>
@endsection
