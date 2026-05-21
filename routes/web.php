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

Route::get('/about', function () { return view('static.about'); })->name('about');
Route::get('/contact', function () { return view('static.contact'); })->name('contact');
Route::get('/privacy', function () { return view('static.privacy'); })->name('privacy');
Route::get('/terms', function () { return view('static.terms'); })->name('terms');

require __DIR__.'/auth.php';
