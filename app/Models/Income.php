<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
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
}
