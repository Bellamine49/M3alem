<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function workerProfile()
    {
        return $this->hasOne(WorkerProfile::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function conversationsAsClient()
    {
        return $this->hasMany(Conversation::class, 'client_id');
    }

    public function conversations()
    {
        if ($this->role === 'worker' && $this->workerProfile) {
            return $this->workerProfile->conversations();
        }
        return $this->conversationsAsClient();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'client_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function isWorker()
    {
        return $this->role === 'worker';
    }

    public function unreadMessagesCount()
    {
        if ($this->role === 'worker' && $this->workerProfile) {
            return Conversation::where('worker_profile_id', $this->workerProfile->id)
                ->whereHas('messages', function ($q) {
                    $q->where('sender_id', '!=', $this->id);
                })
                ->count();
        }

        return Conversation::where('client_id', $this->id)
            ->whereHas('messages', function ($q) {
                $q->where('sender_id', '!=', $this->id);
            })
            ->count();
    }

    public function favorites()
    {
        return $this->belongsToMany(WorkerProfile::class, 'favorites', 'user_id', 'worker_profile_id')->withTimestamps();
    }

    public function recentlyViewed()
    {
        return $this->belongsToMany(WorkerProfile::class, 'recently_viewed', 'user_id', 'worker_profile_id')
            ->withTimestamps()
            ->orderByPivot('created_at', 'desc')
            ->limit(10);
    }
}
