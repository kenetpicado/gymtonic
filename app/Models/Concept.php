<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'has_income',
        'notify_income',
        'has_expenditure',
        'notify_expenditure'
    ];

    public function expenditures()
    {
        return $this->morphMany(Expenditure::class, 'expenditureable');
    }
}
