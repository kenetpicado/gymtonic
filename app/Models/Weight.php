<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'customer_id',
    ];

    protected $appends = [
        'created_at_format',
        'created_at_humman',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCreatedAtFormatAttribute()
    {
        return date('d/m/Y', strtotime($this->created_at));
    }

    public function getCreatedAtHummanAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
