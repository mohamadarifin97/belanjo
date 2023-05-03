<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use function PHPSTORM_META\map;

class Spending extends Model
{
    use HasFactory;

    protected $fillable = [
        'spend_list',
        'total',
        'month',
        'year',
        'created_at',
        'updated_at'
    ];

    public function monthlyIncomes(): HasMany
    {
        return $this->hasMany(MonthlyIncome::class);
    }

    public function spendingDetails(): HasMany
    {
        return $this->hasMany(MonthlyIncome::class);
    }
}
