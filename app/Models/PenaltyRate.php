<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenaltyRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'penalty_percent',
        'penalty_name',
        'penalty_days'
    ];
}
