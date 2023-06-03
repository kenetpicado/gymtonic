<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $appends = [
        'created_at_formatted',
    ];

    protected $fillable = [
        'amount',
        'discount',
        'concept',
        'quantity',
        'description',
        'incomeable_id',
        'incomeable_type',
    ];

    public function incomeable()
    {
        return $this->morphTo();
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
