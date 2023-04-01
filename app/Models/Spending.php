<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Spending extends Model
{
    use HasFactory;

    protected $fillable = [
        'spend_list',
        'total',
        'month',
        'year'
    ];

    // protected $casts = [
    //     'spend_list' => 'array'
    // ];
}
