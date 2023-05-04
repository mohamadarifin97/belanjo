<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpendingDetail extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillabel = [
        'spend',
        'value'
    ];

    public function spending(): BelongsTo
    {
        return $this->belongsTo(Spending::class);
    }
}
