<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'client_id', 'worker_profile_id',
        'amount', 'currency', 'stripe_payment_intent_id',
        'status', 'payment_method',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }
}
