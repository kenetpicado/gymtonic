<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'schedule',
    ];

    public function payments()
    {
        return $this->morphMany(Expenditure::class, 'expenditureable')->orderBy('created_at', 'desc');
    }
}
