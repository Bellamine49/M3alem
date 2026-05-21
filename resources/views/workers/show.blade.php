@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('workers.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to workers
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="h-32 bg-gradient-to-r from-brand-600 to-purple-600"></div>
                <div class="px-6 pb-6">
                    <div class="flex flex-col sm:flex-row sm:items-end -mt-12 mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-brand-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-xl border-4 border-white dark:border-gray-800">
                            {{ substr($worker->user->name, 0, 1) }}
                        </div>
                        <div class="sm:ml-4 mt-4 sm:mt-0 flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $worker->user->name }}</h1>
                                    <div class="flex items-center mt-1 space-x-2 flex-wrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 bg-brand-50 dark:bg-brand-900/20 text-brand-700 dark:text-brand-400 text-sm font-medium rounded-lg">{{ $worker->category->name }}</span>
                                        @if($worker->is_verified)
                                        <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 text-xs font-medium rounded"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                                        @endif
                                        @if($worker->instant_booking)
                                        <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-xs font-medium rounded"><i class="fas fa-bolt mr-1"></i>Instant Booking</span>
                                        @endif
                                        @if($worker->response_time)
                                        <span class="inline-flex items-center px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 text-xs font-medium rounded"><i class="fas fa-clock mr-1"></i>{{ $worker->response_time }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center mb-6">
                        <div class="flex text-accent-500">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($worker->rating) ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $worker->rating }}</span>
                        <span class="ml-1 text-gray-500 dark:text-gray-400">({{ $worker->total_reviews }} reviews)</span>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $worker->price_per_unit }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ str_replace('_', ' ', $worker->price_unit) }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $worker->experience_years }}</p>
                            <p class="text-sm text-gray-500 mt-1">Years exp.</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-gray-900">{{ $worker->total_reviews }}</p>
                            <p class="text-sm text-gray-500 mt-1">Reviews</p>
                        </div>
                    </div>

                    @if($worker->phone)
                    <div class="bg-brand-50 border border-brand-100 rounded-xl p-4 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-brand-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-phone text-brand-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-brand-600 font-medium uppercase tracking-wider">Contact</p>
                            <p class="text-brand-900 font-semibold">{{ $worker->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($worker->bio)
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">About</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $worker->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-6">Reviews ({{ $worker->total_reviews }})</h3>
                @forelse($worker->reviews->sortByDesc('created_at') as $review)
                <div class="border-b border-gray-100 pb-5 mb-5 last:border-0 last:pb-0 last:mb-0">
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                            <div class="flex text-accent-500 text-xs mt-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <span class="ml-auto text-sm text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @if($review->comment)
                    <p class="text-gray-600 text-sm leading-relaxed ml-13">{{ $review->comment }}</p>
                    @endif
                </div>
                @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-comment-slash text-gray-400 text-xl"></i>
                    </div>
                    <p class="text-gray-500">No reviews yet. Be the first!</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            @auth
            @if(auth()->id() !== $worker->user_id)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:sticky lg:top-24 space-y-6">
                <div x-data="datePicker()">
                    <h3 class="font-semibold text-gray-900 mb-4">Book a Service</h3>
                    <form action="{{ route('bookings.store', $worker) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                            
                            <!-- Date picker trigger -->
                            <button type="button" @click="calendarOpen = !calendarOpen" 
                                    class="w-full flex items-center justify-between px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl hover:border-gray-300 transition-all text-left"
                                    :class="{ 'border-brand-500 ring-2 ring-brand-500/20': calendarOpen }">
                                <div>
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">When?</p>
                                    <p class="text-sm text-gray-900 mt-0.5" x-text="selectedDate || 'Pick a date'"></p>
                                </div>
                                <i class="fas fa-calendar-alt text-gray-400" :class="{ 'text-brand-500': calendarOpen }"></i>
                            </button>
                            <input type="hidden" name="booking_date" :value="selectedDateValue">
                            
                            <!-- Calendar dropdown -->
                            <div x-show="calendarOpen" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="fixed sm:absolute z-50 inset-x-4 sm:inset-x-auto sm:mt-2 sm:w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                                
                                <!-- Month navigation -->
                                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                                    <button type="button" @click="prevMonth()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-chevron-left text-gray-600 text-sm"></i>
                                    </button>
                                    <span class="text-sm font-semibold text-gray-900" x-text="monthNames[currentMonth] + ' ' + currentYear"></span>
                                    <button type="button" @click="nextMonth()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-chevron-right text-gray-600 text-sm"></i>
                                    </button>
                                </div>
                                
                                <!-- Weekday headers -->
                                <div class="grid grid-cols-7 px-3 py-2">
                                    <template x-for="day in ['Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa', 'Di']" :key="day">
                                        <div class="text-center text-xs font-medium text-gray-400 py-1" x-text="day"></div>
                                    </template>
                                </div>
                                
                                <!-- Calendar grid -->
                                <div class="grid grid-cols-7 px-3 pb-3">
                                    <template x-for="(day, index) in calendarDays" :key="index">
                                        <button type="button" 
                                                @click="selectDate(day)"
                                                class="w-9 h-9 flex items-center justify-center rounded-full text-sm transition-all"
                                                :class="{
                                                    'bg-brand-600 text-white font-semibold': day.date === selectedDateValue,
                                                    'text-gray-300 cursor-not-allowed': day.disabled,
                                                    'text-gray-900 hover:bg-gray-100': !day.disabled && day.date !== selectedDateValue,
                                                    'bg-gray-50': day.today && day.date !== selectedDateValue
                                                }"
                                                x-text="day.day"
                                                :disabled="day.disabled">
                                        </button>
                                    </template>
                                </div>
                                
                                <!-- Flexible dates -->
                                <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Flexible</p>
                                    <div class="flex gap-1.5">
                                        <template x-for="option in flexibleOptions" :key="option.value">
                                            <button type="button" @click="selectFlexible(option)" 
                                                    class="flex-1 px-2 py-1.5 text-xs font-medium rounded-lg transition-all"
                                                    :class="selectedFlexible === option.value ? 'bg-brand-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                                                    x-text="option.label">
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes (optional)</label>
                            <textarea name="notes" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" placeholder="Describe what you need..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-brand-700 text-white py-3 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all">
                            <i class="fas fa-calendar-check mr-2"></i>Request Booking
                        </button>
                    </form>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Send a Message</h3>
                    <form action="{{ route('messages.start', $worker) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <textarea name="body" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" placeholder="Hi, I'm interested in your services..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gray-900 text-white py-2.5 rounded-xl font-semibold hover:bg-gray-800 transition-all">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store', $worker) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Your Rating</label>
                            <div class="flex space-x-1" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-btn text-2xl text-gray-300 hover:text-accent-500 transition-colors" data-value="{{ $i }}">
                                    <i class="fas fa-star"></i>
                                </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-value" required>
                            <p id="rating-text" class="text-sm text-gray-500 mt-1"></p>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                            <textarea name="comment" rows="2" class="w-full px-3 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm" placeholder="Share your experience..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-brand-600 to-brand-700 text-white py-2.5 rounded-xl font-semibold hover:from-brand-700 hover:to-brand-800 shadow-lg shadow-brand-500/25 transition-all">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-cog text-brand-600"></i>
                </div>
                <p class="text-gray-600 text-sm">This is your profile</p>
                <a href="{{ route('profile.edit') }}" class="inline-block mt-3 text-brand-600 font-medium text-sm hover:text-brand-700">Edit Profile <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            @endif
            @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-lock text-brand-600"></i>
                </div>
                <p class="text-gray-600 text-sm mb-3">Login to book or message</p>
                <a href="{{ route('login') }}" class="inline-block bg-brand-600 text-white px-6 py-2 rounded-xl text-sm font-semibold hover:bg-brand-700 transition-colors">Login</a>
            </div>
            @endauth

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Similar Workers</h3>
                <div class="space-y-3">
                    @forelse($relatedWorkers as $related)
                    <a href="{{ route('workers.show', $related) }}" class="flex items-center p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                        <div class="w-12 h-12 bg-gradient-to-br from-brand-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold shadow-sm">
                            {{ substr($related->user->name, 0, 1) }}
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate group-hover:text-brand-600 transition-colors">{{ $related->user->name }}</p>
                            <div class="flex items-center text-xs text-gray-500">
                                <div class="flex text-accent-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= round($related->rating) ? '' : '-o' }} text-[10px]"></i>
                                    @endfor
                                </div>
                                <span class="ml-1">{{ $related->rating }}</span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <p class="text-gray-400 text-sm text-center py-4">No similar workers</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function datePicker() {
    return {
        calendarOpen: false,
        selectedDate: '',
        selectedDateValue: '',
        selectedFlexible: '',
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),
        monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
        flexibleOptions: [
            { label: '±1j', value: '1' },
            { label: '±2j', value: '2' },
            { label: '±3j', value: '3' },
            { label: '±7j', value: '7' }
        ],
        get calendarDays() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const startOffset = firstDay === 0 ? 6 : firstDay - 1;
            const days = [];
            
            for (let i = 0; i < startOffset; i++) {
                days.push({ day: '', disabled: true, date: '', today: false });
            }
            
            for (let d = 1; d <= daysInMonth; d++) {
                const date = new Date(this.currentYear, this.currentMonth, d);
                const dateStr = date.toISOString().split('T')[0];
                const isPast = date < today;
                days.push({
                    day: d,
                    disabled: isPast,
                    date: dateStr,
                    today: date.toDateString() === today.toDateString()
                });
            }
            
            return days;
        },
        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },
        selectDate(day) {
            if (day.disabled) return;
            this.selectedDate = day.date;
            this.selectedDateValue = day.date;
            this.calendarOpen = false;
        },
        selectFlexible(option) {
            this.selectedFlexible = option.value;
            if (this.selectedDateValue) {
                const baseDate = new Date(this.selectedDateValue);
                const randomOffset = Math.floor(Math.random() * (parseInt(option.value) * 2 + 1)) - parseInt(option.value);
                const newDate = new Date(baseDate);
                newDate.setDate(newDate.getDate() + randomOffset);
                this.selectedDateValue = newDate.toISOString().split('T')[0];
                this.selectedDate = this.selectedDateValue;
            }
        }
    }
}

document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const value = this.dataset.value;
        document.getElementById('rating-value').value = value;
        const texts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        document.getElementById('rating-text').textContent = texts[value];
        document.querySelectorAll('.star-btn').forEach((b, i) => {
            b.classList.toggle('text-accent-500', i < value);
            b.classList.toggle('text-gray-300', i >= value);
        });
    });
});
</script>
@endsection
