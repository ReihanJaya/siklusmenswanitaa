<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'log_date' => 'date',
        'pain_level' => 'integer',
        'fatigue' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
