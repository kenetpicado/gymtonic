<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'quantity',
        'concept',
        'description',
        'expenditureable_id',
        'expenditureable_type',
        'created_at',
    ];

    public function expenditureable()
    {
        return $this->morphTo();
    }

    public function scopeSearch($query, $search = null)
    {
        return $query->when($search, function ($query) use ($search) {
            $query->whereHas('expenditureable', fn ($query) => $query->where('name', 'like', "%{$search}%"));
        });
    }
}
