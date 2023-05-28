<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function prices()
    {
        return $this->hasMany(Price::class)->orderBy('period');
    }
}
