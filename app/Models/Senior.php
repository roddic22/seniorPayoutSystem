<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Senior extends Model
{
    protected $fillable = [
        'osca_id', 'name', 'address', 'age',
        'birthdate', 'sex', 'contact_number',
        'barangay_id', 'status'
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function transactions()
    {
        return $this->hasMany(PayoutTransaction::class);
    }
}