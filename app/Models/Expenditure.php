<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $appends = ['created_at_formatted'];

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
