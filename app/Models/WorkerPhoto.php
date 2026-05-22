<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerPhoto extends Model
{
    protected $fillable = [
        'worker_profile_id', 'photo_path', 'caption', 'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }

    public function getUrlAttribute()
    {
        return '/' . ltrim($this->photo_path, '/');
    }
}
