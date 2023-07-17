<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    public static $periods = [
        [
            'period_label' => 'Dia',
            'period' => 1,
        ],
        [
            'period_label' => 'Semana',
            'period' => 7,
        ],
        [
            'period_label' => 'Quincena',
            'period' => 15,
        ],
        [
            'period_label' => 'Mes',
            'period' => 30,
        ],
    ];

    public function prices()
    {
        return $this->hasMany(Price::class)->orderBy('period');
    }
}
