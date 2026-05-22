<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $fillable = [
        'user_id', 'endpoint', 'auth_key', 'p256dh_key', 'device_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
