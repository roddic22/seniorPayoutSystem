<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSubmission extends Model
{
    protected $fillable = [
        'transaction_id', 'requirement_id',
        'is_submitted', 'notes'
    ];

    protected $casts = [
        'is_submitted' => 'boolean',
    ];

    public function transaction()
    {
        return $this->belongsTo(PayoutTransaction::class, 'transaction_id');
    }

    public function requirement()
    {
        return $this->belongsTo(DocumentRequirement::class, 'requirement_id');
    }
}
