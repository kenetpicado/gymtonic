<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'birth_date',
        'gender'
    ];

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    public function weights()
    {
        return $this->hasMany(Weight::class)->orderBy('id','desc');
    }

    public function incomes()
    {
        return $this->morphMany(Income::class, 'incomeable')->orderBy('id','desc');
    }
}
