<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterBilling extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_bill',
        'amount_billing',
        'volume',
        'meter_consume',
        'transaction_date'
    ];

    // public function info(){
    //     return $this->hasMany(User::class, 'bill_id');
    // }
    public function encoder(){
        return $this->belongsTo(Encoder::class, 'account_id');
    }
}
