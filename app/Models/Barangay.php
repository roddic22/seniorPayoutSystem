<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    protected $fillable = ['name', 'city'];

    public function seniors()
    {
        return $this->hasMany(Senior::class);
    }

    public function schedules()
    {
        return $this->hasMany(PayoutSchedule::class);
    }
}