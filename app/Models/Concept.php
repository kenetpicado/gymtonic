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
        'has_expenditure',
    ];

    public function expenditures()
    {
        return $this->morphMany(Expenditure::class, 'expenditureable');
    }

    public function incomes()
    {
        return $this->morphMany(Income::class, 'incomeable');
    }

    public function lastExpenditure()
    {
        return $this->morphOne(Expenditure::class, 'expenditureable')->latest();
    }
}
