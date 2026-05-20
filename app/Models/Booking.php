<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id', 'worker_profile_id',
        'booking_date', 'status', 'notes',
    ];

    protected $casts = ['booking_date' => 'date'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }
}
