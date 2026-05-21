<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    protected $table = 'recently_viewed';

    protected $fillable = ['user_id', 'worker_profile_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }
}
