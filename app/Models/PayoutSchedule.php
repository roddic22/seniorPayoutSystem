<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutSchedule extends Model
{
    protected $fillable = [
        'cycle_id', 'barangay_id', 'scheduled_date',
        'time_start', 'time_end', 'venue'
    ];

    public function cycle()
    {
        return $this->belongsTo(PayoutCycle::class, 'cycle_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function staffAssignments()
    {
        return $this->hasMany(StaffAssignment::class, 'schedule_id');
    }

    public function transactions()
    {
        return $this->hasMany(PayoutTransaction::class, 'schedule_id');
    }
}