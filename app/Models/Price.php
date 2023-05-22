<?php

namespace App\Models;

use App\Enums\PeriodEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'period',
        'value',
        'service_id',
    ];

    protected $appends = [
        'period_label',
    ];

    public function getPeriodLabelAttribute()
    {
        return PeriodEnum::getLabel($this->period);
    }
}
