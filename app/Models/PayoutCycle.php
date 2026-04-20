<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutCycle extends Model
{
    protected $fillable = [
        'cycle_name', 'period_start',
        'period_end', 'status', 'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function schedules()
    {
        return $this->hasMany(PayoutSchedule::class, 'cycle_id');
    }

    public function requirements()
    {
        return $this->hasMany(DocumentRequirement::class, 'cycle_id');
    }

    public function transactions()
    {
        return $this->hasMany(PayoutTransaction::class, 'cycle_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'cycle_id');
    }
}