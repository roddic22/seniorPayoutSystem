<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    protected $fillable = ['counter_number', 'label', 'is_active'];

    public function staffAssignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }

    public function transactions()
    {
        return $this->hasMany(PayoutTransaction::class);
    }
}