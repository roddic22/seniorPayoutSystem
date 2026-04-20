<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRequirement extends Model
{
    protected $fillable = [
        'cycle_id', 'document_name',
        'description', 'is_mandatory'
    ];

    public function cycle()
    {
        return $this->belongsTo(PayoutCycle::class, 'cycle_id');
    }

    public function submissions()
    {
        return $this->hasMany(DocumentSubmission::class, 'requirement_id');
    }
}