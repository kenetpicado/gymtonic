<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $appends = [
        'start_date_formated',
        'end_date_formated',
    ];

    protected $fillable = [
        'period',
        'start_date',
        'end_date',
        'amount',
        'discount',
        'note',
        'service_id',
    ];

    public $periods = [
        [
            'label' => 'Mes',
            'key' => 30,
        ],
        [
            'label' => 'Quincena',
            'key' => 15,
        ],
        [
            'label' => 'Semana',
            'key' => 7,
        ],
        [
            'label' => 'Dia',
            'key' => 1,
        ]
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getStartDateFormatedAttribute()
    {
        return Carbon::parse($this->start_date)->format('d/m/Y');
    }

    public function getEndDateFormatedAttribute()
    {
        return Carbon::parse($this->end_date)->format('d/m/Y');
    }
}
