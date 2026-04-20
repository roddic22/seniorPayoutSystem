<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAssignment extends Model
{
    protected $fillable = ['schedule_id', 'user_id', 'counter_id'];

    public function schedule()
    {
        return $this->belongsTo(PayoutSchedule::class, 'schedule_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}