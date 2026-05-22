<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id', 'worker_profile_id',
        'booking_date', 'status', 'notes',
        'proposed_price', 'counter_price', 'price_status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'proposed_price' => 'decimal:2',
        'counter_price' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
