<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'cycle_id', 'generated_by',
        'report_type', 'file_path', 'generated_at'
    ];

    public function cycle()
    {
        return $this->belongsTo(PayoutCycle::class, 'cycle_id');
    }

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}