<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cashback',
        'amount',
        'status',
        'payment_method',
        'payment_ref'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(product::class);
    }
    public function getTotalPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }
    public function getQuantityAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
