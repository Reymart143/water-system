<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'discount_percent',
        'discount_name',
        'discount_days'
    ];
}
