<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    use HasFactory;

    protected $fillable = [
        'spend_list',
        'total'
    ];

    // protected $casts = [
    //     'spend_list' => 'array'
    // ];
}
