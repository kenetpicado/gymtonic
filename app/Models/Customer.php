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

    protected $appends = [
        'age'
    ];

    public function getAgeattribute()
    {
        return now()->diffInYears($this->birth_date);
    }

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    public function weights()
    {
        return $this->hasMany(Weight::class)->orderBy('id','desc');
    }
}
