<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'phone',
        'bio',
        'price_per_unit',
        'price_unit',
        'city',
        'experience_years',
        'is_available',
        'is_verified',
        'instant_booking',
        'response_time',
        'badges',
        'rating',
        'total_reviews',
    ];

    public function photos()
    {
        return $this->hasMany(WorkerPhoto::class);
    }

    public function primaryPhoto()
    {
        return $this->hasOne(WorkerPhoto::class)->where('is_primary', true);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected $casts = [
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'instant_booking' => 'boolean',
        'badges' => 'array',
        'price_per_unit' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'worker_profile_id', 'user_id')->withTimestamps();
    }

    public function recentlyViewedBy()
    {
        return $this->belongsToMany(User::class, 'recently_viewed', 'worker_profile_id', 'user_id')->withTimestamps();
    }
}
