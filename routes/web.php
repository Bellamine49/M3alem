<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Models\Category;
use App\Models\WorkerProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::withCount('workerProfiles')->limit(8)->get();
    $topWorkers = WorkerProfile::with(['user', 'category'])
        ->where('is_available', true)
        ->orderBy('rating', 'desc')
        ->limit(6)
        ->get();
    $cities = WorkerProfile::whereNotNull('city')->distinct()->pluck('city')->filter()->values();
    $suggestions = $categories->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'icon' => $c->icon ?? '🔧', 'count' => $c->worker_profiles_count]);
    return view('home', compact('categories', 'topWorkers', 'cities', 'suggestions'));
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/workers', [WorkerController::class, 'index'])->name('workers.index');
Route::get('/workers/{worker}', [WorkerController::class, 'show'])->name('workers.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/worker', [ProfileController::class, 'updateWorkerProfile'])->name('profile.worker.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/workers/{worker}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/workers/{worker}/messages', [MessageController::class, 'start'])->name('messages.start');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');

    Route::post('/workers/{worker}/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/workers/{worker}/bookings', [BookingController::class, 'getBookings'])->name('bookings.get');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/workers/{worker}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::middleware('auth')->group(function () {
    Route::post('/push/subscribe', [\App\Http\Controllers\PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::delete('/push/unsubscribe', [\App\Http\Controllers\PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');

    Route::post('/workers/{worker}/photos', [\App\Http\Controllers\WorkerPhotoController::class, 'store'])->name('worker.photos.store');
    Route::delete('/photos/{photo}', [\App\Http\Controllers\WorkerPhotoController::class, 'destroy'])->name('worker.photos.destroy');
    Route::patch('/photos/{photo}/primary', [\App\Http\Controllers\WorkerPhotoController::class, 'setPrimary'])->name('worker.photos.primary');

    Route::post('/bookings/{booking}/counter-offer', [\App\Http\Controllers\BookingController::class, 'counterOffer'])->name('bookings.counterOffer');
    Route::post('/bookings/{booking}/accept-price', [\App\Http\Controllers\BookingController::class, 'acceptPrice'])->name('bookings.acceptPrice');

    Route::get('/bookings/{booking}/payment/checkout', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/bookings/{booking}/payment/intent', [\App\Http\Controllers\PaymentController::class, 'createIntent'])->name('payment.intent');
    Route::get('/bookings/{booking}/payment/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payments', [\App\Http\Controllers\PaymentController::class, 'history'])->name('payments.index');
});

Route::post('/stripe/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('stripe.webhook');

Route::get('/about', function () { return view('static.about'); })->name('about');
Route::get('/contact', function () { return view('static.contact'); })->name('contact');
Route::get('/privacy', function () { return view('static.privacy'); })->name('privacy');
Route::get('/terms', function () { return view('static.terms'); })->name('terms');

require __DIR__.'/auth.php';
