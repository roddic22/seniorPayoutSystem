<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutTransaction extends Model
{
    protected $fillable = [
        'cycle_id', 'senior_id', 'schedule_id',
        'counter_id', 'processed_by', 'amount',
        'claim_status', 'claimed_at', 'remarks'
    ];

    public function cycle()
    {
        return $this->belongsTo(PayoutCycle::class, 'cycle_id');
    }

    public function senior()
    {
        return $this->belongsTo(Senior::class, 'senior_id');
    }

    public function schedule()
    {
        return $this->belongsTo(PayoutSchedule::class, 'schedule_id');
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function submissions()
    {
        return $this->hasMany(DocumentSubmission::class, 'transaction_id');
    }
}